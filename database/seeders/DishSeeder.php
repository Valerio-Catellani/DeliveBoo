<?php

namespace Database\Seeders;

use App\Models\Restaurant;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Dish;

class DishSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $restaurants = Restaurant::with('typologies')->get();
        $all_dishes = json_decode(file_get_contents(__DIR__ . '\json\Dishes.json'));

        foreach ($restaurants as $restaurant) {
            $typologies_of_restaurant = [];
            foreach ($restaurant->typologies as $typology) {
                $typologies_of_restaurant[] = $typology->name;
            }

            $filtered_dishes = array_filter($all_dishes, function ($single_dish) use ($typologies_of_restaurant) {
                return in_array($single_dish->categoria, $typologies_of_restaurant);
            });

            //count($filtered_dishes)
            $random_number_of_dishes = rand(3, count($filtered_dishes));
            $random_price_increment = rand(1, 10);

            for ($i = 0; $i < $random_number_of_dishes; $i++) {
                $random_key = array_rand($filtered_dishes);
                $random_dish = $filtered_dishes[$random_key];
                unset($filtered_dishes[$random_key]);
                $new_dish = new Dish();
                $new_dish->name = $random_dish->name; 


                dump($random_dish);
            }
            dd('fine');
        }
    }
}