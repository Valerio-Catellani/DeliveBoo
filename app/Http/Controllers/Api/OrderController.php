<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\DishOrder;
use App\Models\Dish;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;

use Illuminate\Support\Str;
use App\Models\Restaurant;
use App\Models\Order;


class OrderController extends Controller
{
    public function findOrders(Request $request)
    {
        if ($request->query('month')) {
            // Ottieni il ristorante associato all'utente autenticato
            //http://127.0.0.1:8000/api/get-orders?month=7&user_id=2


            $month = $request->query('month');
            $user_id = $request->query('user_id');
            $restaurant =  Restaurant::where('user_id', $user_id)->first();


            if (!$restaurant) {
                return response()->json(['error' => 'Restaurant not found'], 404);
            }

            // Numero totale di ordini nel mese specificato per il ristorante
            $ordersGroupedByDay = Order::selectRaw('DATE(order_date) as day, COUNT(*) as number_of_orders, SUM(total_price) as total_price')
                ->whereMonth('order_date', $month)
                ->whereHas('dishes', function ($query) use ($restaurant) {
                    $query->where('restaurant_id', $restaurant->id);
                })
                ->groupBy(DB::raw('DATE(order_date)'))
                ->orderBy('day', 'asc')
                ->get();


            // Guadagno totale nel mese specificato per il ristorante
            $total_price = Order::whereHas('dishes', function ($query) use ($restaurant) {
                $query->where('restaurant_id', $restaurant->id);
            })->whereMonth('order_date', $month)
                ->sum('total_price');

            // Ottenere i piatti venduti nel mese specificato con quantità
            $dishes = Dish::where('restaurant_id', $restaurant->id)
                ->whereHas('orders', function ($query) use ($month) {
                    $query->whereMonth('orders.order_date', $month);
                })
                ->with(['orders' => function ($query) use ($month) {
                    $query->select('dish_quantity')
                        ->whereMonth('orders.order_date', $month);
                }])
                ->get();

            // Calcolare la quantità totale per ogni piatto
            $dish_data = $dishes->map(function ($dish) {
                $total_quantity = $dish->orders->sum('pivot.quantity');
                return [
                    'dish_id' => $dish->id,
                    'dish_name' => $dish->name, // Assumendo che il modello Dish abbia un campo 'name'
                    'dish_image' => $dish->image, // Assumendo che il modello Dish abbia un campo 'image'
                    'total_quantity' => $total_quantity
                ];
            });

            // // Restituisci i dati come un array associativo
            $orders = [
                'number_of_orders' => $ordersGroupedByDay,
                'total_price' => $total_price,
                'dishes' => $dishes
            ];
        }
        // http://127.0.0.1:8000/api/get-orders
        else {
            $orders = Order::select('id', 'total_price', 'order_date')
                ->with(['dishes' => function ($query) {
                    $query->select('dishes.id', 'dishes.name', 'dishes.slug', 'dishes.image', 'restaurant_id', 'order_id', 'price'); // Carica solo i campi necessari dai piatti
                }, 'dishes.restaurant' => function ($query) {
                    $query->select('restaurants.id', 'name'); // Carica l'ID e il nome del ristorante
                }])
                ->paginate(10);
        }

        if ($orders) {
            return response()->json(
                [
                    'status' => 'success',
                    'message' => 'ok',
                    'results' => $orders
                ],
                200
            );
        } else {
            return response()->json(
                [
                    'status' => 'error',
                    'message' => 'Nessuna Ordinazione Trovata'
                ],
                400
            );
        }
    }

    // http://127.0.0.1:8000/api/get-orders/ristorante-altera-order-1
    public function findSingleOrder($slug)
    {
        $order = Order::where('slug', $slug)
            ->select('id', 'total_price', 'order_date')
            ->with(['dishes' => function ($query) {
                $query->select('dishes.id', 'dishes.name', 'dishes.slug', 'restaurant_id', 'order_id', 'price'); // Carica solo i campi necessari dai piatti
            }, 'dishes.restaurant' => function ($query) {
                $query->select('restaurants.id', 'name'); // Carica l'ID e il nome del ristorante
            }])
            ->get();


        if ($order) {
            return response()->json(
                [
                    'status' => 'success',
                    'message' => 'ok',
                    'results' => $order
                ],
                200
            );
        } else {
            return response()->json(
                [
                    'status' => 'error',
                    'message' => 'Nessuna Ordinazione Trovata'
                ],
                400
            );
        }
    }
}
