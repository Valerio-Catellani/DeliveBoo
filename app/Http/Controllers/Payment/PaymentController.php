<?php

namespace App\Http\Controllers\Payment;

use App\Services\BraintreeService;
use App\Http\Controllers\Controller;
use App\Mail\NewContact;
use App\Models\Restaurant;
use App\Models\User;
use App\Models\Dish;
use App\Models\DishOrder;
use App\Models\Cart;
use App\Models\Order;
use Carbon\Carbon;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Mail;

use Illuminate\Http\Request;

class PaymentController extends Controller
{
    protected $braintree;

    public function __construct(BraintreeService $braintree)
    {
        $this->braintree = $braintree;
    }

    public function createToken()
    {
        $clientToken = $this->braintree->gateway()->clientToken()->generate();
        return response()->json(['token' => $clientToken]);
    }

    public function processPayment(Request $request)
    {
        $data = $request->all();

        //prendo il ristornate
        $restaurant = Restaurant::where('id', $request->input('cart.restaurantId'))->first();
        //!ERRORE: RISTORANTE NON TROVATO
        if (!$restaurant) {
            return response()->json(['success' => false, 'error' => 'Ristorante non trovato']);
        }
        //prendo l'utente
        $user = User::where('id', $restaurant->user_id)->first();
        //!ERRORE UTENTE NON TROVATO
        if (!$user) {
            return response()->json(['success' => false, 'error' => 'Utente non trovato']);
        }
        //imposto il totale a 0
        $amount = 0;

        //per ogni piatto dentro al carrello recupero il piatto dal db mediante lo slug
        foreach ($request->input('cart.dishes') as $dish) {
            $dish_on_db = Dish::where('slug', $dish['slug'])->first();;

            //!ERRORE PIATTO NON TROVATO (NON ESISTE, NON VISIBILE O QUANTità SELEZIONATA NON VALIDA)
            if (!$dish_on_db || !$dish_on_db->visible || $dish_on_db->restaurant_id !== $restaurant->id) {
                return response()->json(['success' => false, 'error' => 'Piatto non trovato']);
            }
            //!ERRORE QUANTITA' SELEZIONATA NON VALIDA
            else if ($dish['qty'] <= 0) {
                return response()->json(['success' => false, 'error' => "$dish_on_db->name: Quantità selezionata non consentita"]);
            }
            //Incremento il prezzo
            else {
                $amount += $dish_on_db->price * $dish['qty'];
            }
        }

        //recupero il token da braintree
        $nonce = $request->payment_method_nonce;

        //VALIDAZIONE DATI ACQUIRENTE
        try {
            $validated =  $request->validate(
                [
                    'customer_name' => ['required', 'string', 'max:255'],
                    'customer_lastname' => ['required', 'string', 'max:255'],
                    'customer_email' => ['required', 'string', 'email', 'max:255'],
                    'customer_adress' => ['required', 'string', 'max:255'],
                    'customer_phone' => ['nullable', 'string', 'size:10'],
                ],
                [
                    'name.required' => 'Il nome è obbligatorio.',
                    'name.string' => 'Il nome deve essere una stringa.',
                    'name.max' => 'Il nome non può superare i 255 caratteri.',

                    'lastname.required' => 'Il cognome è obbligatorio.',
                    'lastname.string' => 'Il cognome deve essere una stringa.',
                    'lastname.max' => 'Il cognome non può superare i 255 caratteri.',

                    'email.required' => 'L\'email è obbligatoria.',
                    'email.string' => 'L\'email deve essere una stringa.',
                    'email.email' => 'Deve essere un indirizzo email valido.',
                    'email.max' => 'L\'email non può superare i 255 caratteri.',

                    'address.required' => 'L\'indirizzo è obbligatorio.',
                    'address.string' => 'L\'indirizzo deve essere una stringa.',
                    'address.min' => 'L\'indirizzo deve avere almeno 3 caratteri.',
                    'address.max' => 'L\'indirizzo non può superare i 255 caratteri.',

                    'phone.string' => 'Il numero di telefono deve essere una stringa.',
                    'phone.min' => 'Il numero di telefono deve essere di 10 cifre.',
                    'phone.max' => 'Il numero di telefono deve essere di 10 cifre.',
                ]
            );
        }
        //!ERRORE VALIDAZIONE DATI ACQUIRENTE -> RITORNO JSON CON GLI ERRORI RELATIVI
        catch (ValidationException $e) {
            return response()->json(['success' => false, 'errors' => $e->errors()]);
        }

        //Aggiungo i dati calcolati a quell validati per le ordinazioni
        $validated['order_date'] =  Carbon::now();
        $validated['total_price'] = $amount;
        $validated['slug'] = Order::generateSlugForOrder($restaurant->slug);


        $result = $this->braintree->gateway()->transaction()->sale([
            'amount' => $amount,
            'paymentMethodNonce' => $nonce,
            'options' => [
                'submitForSettlement' => true
            ]
        ]);

        //* PAGAMENTO EFFETTUATO CON SUCCESSO
        if ($result->success) {

            //CREO L'ORDINE
            $new_order = Order::create([
                'customer_name' => $validated['customer_name'],
                'customer_lastname' => $validated['customer_lastname'],
                'customer_address' => $validated['customer_adress'],
                'customer_phone' => $validated['customer_phone'],
                'customer_email' => $validated['customer_email'],
                'order_date' => $validated['order_date'],
                'total_price' => $validated['total_price'],
                'slug' => $validated['slug'],
            ]);


            $orderedDishes = [];
            //CREO LA RIGHE NELLA TABELLA DISHORDER
            foreach ($request->input('cart.dishes') as $dish) {
                $dish_on_db = Dish::where('slug', $dish['slug'])->first();
                $new_dishOrder = new DishOrder();
                $new_dishOrder->dish_id = $dish_on_db->id;
                $new_dishOrder->order_id = $new_order->id;
                $new_dishOrder->dish_name = $dish_on_db->name;
                $new_dishOrder->dish_quantity = $dish['qty'];
                $new_dishOrder->dish_price = $dish_on_db->price * $dish['qty'];
                $new_dishOrder->save();
                $orderedDishes[] = [
                    'name' => $dish_on_db->name,
                    'qty' => $dish['qty'],
                    'price' => $dish_on_db->price
                ];
            };

            //INVIO LA MAIL AL CLIENTE

            try {

                Mail::to($validated['customer_email'])->send(new NewContact($validated, $orderedDishes));
                Mail::to($user->email)->send(new NewContact($validated, $orderedDishes));
            } catch (\Exception $e) {
                Log::error('Errore durante l\'invio dell\'email: ' . $e->getMessage());
                return response()->json(['success' => false, 'error' => 'Errore durante l\'invio dell\'email.']);
            }

            return response()->json(['success' => true, 'transaction' => $result->transaction]);
        } else {
            return response()->json(['success' => false, 'error' => $result->message]);
        }
    }
}
