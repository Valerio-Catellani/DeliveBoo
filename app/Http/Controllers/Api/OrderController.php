<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Restaurant;
use App\Models\Order;


class OrderController extends Controller
{
    public function findOrders(Request $request)
    {


        if ($request->query('typology')) {
        }
        // http://127.0.0.1:8000/api/get-orders
        else {
            $orders = Order::select('id', 'total_price', 'created_at')
                ->with(['dishes' => function ($query) {
                    $query->select('dishes.id', 'dishes.name', 'dishes.slug', 'restaurant_id', 'order_id', 'price'); // Carica solo i campi necessari dai piatti
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

    // http://127.0.0.1:8000/api/get-orders/1
    public function findSingleOrder($slug)
    {
        $order = Order::where('slug', $slug)
            ->select('id', 'total_price', 'created_at')
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
