<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;
use App\Models\Dish;
use App\Models\Restaurant;

class OrderController extends Controller
{
    public function showBills($user_slug, $restaurant_slug)
    {

        $restaurant = Restaurant::where('slug', $restaurant_slug)->first();
        if ($restaurant && $restaurant->user_id == Auth::user()->id) {

            $orders = Order::with('dishes')
                ->whereHas('dishes', function ($query) use ($restaurant) {
                    $query->where('restaurant_id', $restaurant->id);
                })->get();

            if (count($orders) > 0) {
                return view('admin.orders.index', compact('orders'));
            } else {
                dd('non hai ancora ricevuto ordini');
            }
        }
        dd('error');
    }
}
