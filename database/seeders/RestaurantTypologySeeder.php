<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\RestaurantTypology;
class RestaurantTypologySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $restaurantTypology = json_decode(file_get_contents(__DIR__ . '\json\Restaurants_Typologies.json'));
        foreach ($restaurantTypology as $restaurantTypology) {
            $new_RestaurantTypology = new RestaurantTypology();
            $new_RestaurantTypology->restaurant_id = $restaurantTypology->restaurant_id;
            $new_RestaurantTypology->typology_id = $restaurantTypology->typology_id;
            $new_RestaurantTypology->save();
        }
    }
}
