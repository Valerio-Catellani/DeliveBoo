<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Restaurant;
use App\Models\Order;
use App\Models\Dish;
use App\Models\DishOrder;
use App\Functions\Helpers;


class DishOrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $number_of_orders_for_each_restaurant = Helpers::numberOfOrders();
        $number_of_dishes_for_each_order = 4;
        $restaurants = Restaurant::all();
        $all_orders_id = Order::all('id')->pluck('id')->toArray();

        foreach ($restaurants as $restaurant) {

            $dishes_of_restaurant = Dish::where('restaurant_id', $restaurant->id)->pluck('id')->toArray();
            shuffle($dishes_of_restaurant);

            $keys = array_rand($all_orders_id, $number_of_orders_for_each_restaurant);
            foreach ($keys as $key) {
                $random_id = $all_orders_id[$key];
                for ($i = 0; $i <  $number_of_dishes_for_each_order; $i++) {
                    $new_dishOrder = new DishOrder();
                    $new_dishOrder->dish_id = $dishes_of_restaurant[$i];
                    $new_dishOrder->order_id = $random_id;
                    $new_dishOrder->dish_name = Dish::where('id', $dishes_of_restaurant[$i])->first()->name;
                    $new_dishOrder->dish_quantity = rand(-4, 4);
                    $new_dishOrder->dish_price = (Dish::where('id', $dishes_of_restaurant[$i])->first()->price) * $new_dishOrder->dish_quantity;
                    Order::where('id', $random_id)->update([
                        'total_price' => Order::where('id', $random_id)->first()->total_price + $new_dishOrder->dish_price,
                        'slug' => Order::generateSlugForOrder($restaurant->slug)
                    ]);
                    $new_dishOrder->order_date = Order::where('id', $random_id)->first()->created_at;
                    $new_dishOrder->save();
                };
                unset($all_orders_id[$key]);
            }
        }
    }
}
