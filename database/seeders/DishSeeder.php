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
        // $restaurants = Restaurant::all()->with('categories');
        $dishes = json_decode(file_get_contents(__DIR__ . '/json/Dishes.json'));

        foreach ($dishes as $dish) {
            $new_dish = new Dish();
            $new_dish->name = $dish->name;
            $new_dish->price = $dish->price;
            $new_dish->description = $dish->description;
            $new_dish->image = $dish->image;
            $new_dish->restaurant_id = $dish->restaurant_id;
            $new_dish->visible = $dish->visible;
            $new_dish->ingredients = $dish->ingredients;
            $new_dish->save();
        }
    }
}
