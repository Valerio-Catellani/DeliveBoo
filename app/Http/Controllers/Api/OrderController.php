<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\DishOrder;
use App\Models\Dish;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use App\Functions\Helpers;
use App\Models\Cart;
use Carbon\Carbon;

use Illuminate\Support\Str;
use App\Models\Restaurant;
use App\Models\Order;


class OrderController extends Controller
{
    public function findOrders(Request $request)
    {
        if ($request->query('month') && $request->query('year') && $request->query('user_id')) {
            // Ottieni il ristorante associato all'utente autenticato
            $month = $request->query('month');
            $year = $request->query('year');
            $user_id = $request->query('user_id');
            $restaurant = Restaurant::where('user_id', $user_id)->first();

            if (!$restaurant) {
                return response()->json(['error' => 'Restaurant not found'], 404);
            }

            // Numero totale di ordini nel mese e anno specificati per il ristorante
            $ordersGroupedByDay = Order::selectRaw('DATE(order_date) as day, COUNT(*) as number_of_orders, SUM(total_price) as total_price')
                ->whereMonth('order_date', $month)
                ->whereYear('order_date', $year)
                ->whereHas('dishes', function ($query) use ($restaurant) {
                    $query->where('restaurant_id', $restaurant->id);
                })
                ->groupBy(DB::raw('DATE(order_date)'))
                ->orderBy('day', 'asc')
                ->get();

            // Guadagno totale nel mese e anno specificati per il ristorante
            $total_price = Order::whereHas('dishes', function ($query) use ($restaurant) {
                $query->where('restaurant_id', $restaurant->id);
            })->whereMonth('order_date', $month)
                ->whereYear('order_date', $year)
                ->sum('total_price');

            // Ottenere i piatti venduti nel mese e anno specificati con quantità
            $dishes = Dish::where('restaurant_id', $restaurant->id)
                ->whereHas('orders', function ($query) use ($month, $year) {
                    $query->whereMonth('orders.order_date', $month)
                        ->whereYear('orders.order_date', $year);
                })
                ->with(['orders' => function ($query) use ($month, $year) {
                    $query->select('dish_quantity')
                        ->whereMonth('orders.order_date', $month)
                        ->whereYear('orders.order_date', $year);
                }])
                ->get();

            // Restituisci i dati come un array associativo
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

    public function getOrdersByMonth(Request $request)
    {
        if ($request->query('user_id')) {
            Carbon::setLocale('it');
            $user_id = $request->query('user_id');
            $restaurant = Restaurant::where('user_id', $user_id)->first();

            if (!$restaurant) {
                return response()->json(['error' => 'Restaurant not found'], 404);
            }

            $currentDate = Carbon::now();
            $startDate = $currentDate->copy()->subMonths(11)->startOfMonth();

            // Inizializzare un array per contenere i dati delle ordinazioni per ogni mese
            $ordersByMonth = [];

            // Iterare attraverso ogni mese dal mese iniziale fino al mese corrente
            for ($date = $startDate; $date->lte($currentDate); $date->addMonth()) {
                $month = $date->month;
                $year = $date->year;

                // Ottenere le ordinazioni per il mese corrente
                $monthlyOrders = Order::selectRaw('COUNT(*) as number_of_orders, SUM(total_price) as total_price')
                    ->whereMonth('order_date', $month)
                    ->whereYear('order_date', $year)
                    ->whereHas('dishes', function ($query) use ($restaurant) {
                        $query->where('restaurant_id', $restaurant->id);
                    })
                    ->first();

                // Aggiungere i dati al array
                $ordersByMonth[] = [
                    'month' => $date->isoFormat('MMMM'), // Usa isoFormat per ottenere il nome del mese in italiano
                    'year' => $year,
                    'number_of_orders' => $monthlyOrders->number_of_orders ?? 0,
                    'total_price' => $monthlyOrders->total_price ?? 0,
                ];
            }

            return response()->json(
                [
                    'status' => 'success',
                    'message' => 'ok',
                    'results' => $ordersByMonth
                ],
                200
            );
        } else {
            return response()->json(
                [
                    'status' => 'error',
                    'message' => 'User ID not provided'
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
