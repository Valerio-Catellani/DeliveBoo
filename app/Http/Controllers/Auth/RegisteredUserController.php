<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Restaurant;
use App\Models\User;
use App\Models\Typology;
use App\Functions\Helpers;
use App\Http\Requests\StoreRestaurantRequest;
use Illuminate\Support\Facades\Storage;

use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Validation\ValidationException;

use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        $typologies = Typology::all();
        return view('auth.register', compact('typologies'));
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {

        $validated =  $request->validate(
            [
                'name' => ['required', 'string', 'max:255'],
                'lastname' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
                'password' => ['required', 'confirmed', Rules\Password::defaults()],
                'rest_name' => ['required', 'string', 'min:3', 'max:255'],
                'address' => ['required', 'string', 'min:3', 'max:255'],
                'phone' => ['nullable', 'min:10', 'max:10'],
                'typologies' => ['required', 'array', 'min:1'],
                'VAT' => ['required', 'unique:restaurants', 'string', 'size:11'],
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
                'email.lowercase' => 'L\'email deve essere in minuscolo.',
                'email.email' => 'Deve essere un indirizzo email valido.',
                'email.max' => 'L\'email non può superare i 255 caratteri.',
                'email.unique' => 'L\'email è già in uso.',

                'password.required' => 'La password è obbligatoria.',
                'password.confirmed' => 'Le password non coincidono.',

                'rest_name.required' => 'Il nome del ristorante è obbligatorio.',
                'rest_name.string' => 'Il nome del ristorante deve essere una stringa.',
                'rest_name.min' => 'Il nome del ristorante deve avere almeno 3 caratteri.',
                'rest_name.max' => 'Il nome del ristorante non può superare i 255 caratteri.',

                'address.required' => 'L\'indirizzo è obbligatorio.',
                'address.string' => 'L\'indirizzo deve essere una stringa.',
                'address.min' => 'L\'indirizzo deve avere almeno 3 caratteri.',
                'address.max' => 'L\'indirizzo non può superare i 255 caratteri.',

                'phone.string' => 'Il numero di telefono deve essere una stringa.',
                'phone.min' => 'Il numero di telefono deve essere di 10 cifre.',
                'phone.max' => 'Il numero di telefono deve essere di 10 cifre.',

                'typologies.required' => 'Devi selezionare almeno una tipologia.',
                'typologies.min' => 'Devi selezionare almeno una tipologia.',
                'typologies.*.integer' => 'Ogni tipologia selezionata deve essere un ID valido.',
                'typologies.*.exists' => 'La tipologia selezionata non esiste.',

                'VAT.required' => 'La partita IVA è obbligatoria.',
                'VAT.unique' => 'La partita IVA è già in uso.',
                'VAT.string' => 'La partita IVA deve essere una stringa.',
                'VAT.size' => 'La partita IVA deve essere esattamente di 11 cifre.',
            ]
        );



        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'lastname' => $validated['lastname'],
            'slug' => User::generateSlug($validated['name'], $validated['lastname']),
            'password' => Hash::make($validated['password']),
        ]);

        event(new Registered($user));

        Auth::login($user);

        $validated['slug'] = Helpers::generateSlug($validated['rest_name'], Restaurant::class);
        $validated['user_id'] = Auth::user()->id;

        if ($request->hasFile('image')) {
            $img_path = Storage::put('image', $request->image);
            $validated['image'] = $img_path;
        } else {
            $validated['image'] = 'https://upload.wikimedia.org/wikipedia/commons/thumb/6/65/No-Image-Placeholder.svg/1665px-No-Image-Placeholder.svg.png';
        }

        $new_restaurant = Restaurant::create([
            'name' => $validated['rest_name'],
            'slug' => $validated['slug'],
            'user_id' => $validated['user_id'],
            'address' => $validated['address'],
            'phone' => $validated['phone'],
            'image' => $validated['image'],
            'VAT' => $validated['VAT'],
        ]);

        if ($validated['typologies']) {
            $new_restaurant->typologies()->attach($request->typologies);
        }

        $new_restaurant->save();

        // event(new Registered($user));

        // Auth::login($user);
        $request->session()->regenerate();

        $user = auth()->user();
        $request->session()->put('user_id', $user->id);
        $request->session()->put('user_slug', $user->slug);
        $request->session()->put('user_name', $user->name);
        $request->session()->put('user_lastname', $user->lastname);

        return redirect(RouteServiceProvider::HOME);
    }

    public function checkRegistration(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'lastname' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);
    }
}
