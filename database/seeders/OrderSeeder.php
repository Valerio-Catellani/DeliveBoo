<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Order;
use App\Models\Restaurant;
use App\Functions\Helpers;
use Faker\Generator as Faker;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */


    public function run(Faker $faker): void
    {
       $restaurants = Restaurant::All();
       $number_of_restaurants = count($restaurants);

       $number_of_orders = Helpers::numberOfOrders();

        for ($i = 0; $i < $number_of_restaurants*$number_of_orders ; $i++) {
            $new_order = new Order();

            $new_order->customer_name = $faker->firstName();
            $new_order->customer_lastname = $faker->lastName();
            $new_order->customer_address = $faker->address();
            $new_order->customer_phone = $faker->phoneNumber();
            $new_order->customer_email = $faker->email();
            $new_order->order_date = $faker->dateTimeBetween('-1 month', '+1 month');
            $new_order->total_price = 0.00;

            $new_order->save();
        };
    }
}
