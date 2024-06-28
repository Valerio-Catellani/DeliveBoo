<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Restaurant;

class RestaurantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $restaurants = json_decode(file_get_contents(__DIR__ . '\json\Restaurants.json'));
        foreach ($restaurants as $restaurant) {
            $new_Restaurant = new Restaurant();
            $new_Restaurant->name = $restaurant->Name;
            $new_Restaurant->address = $restaurant->Address;
            $new_Restaurant->image = $restaurant->image;
            $new_Restaurant->VAT = $restaurant->VAT;
            $new_Restaurant->save();
        }
    }
}
