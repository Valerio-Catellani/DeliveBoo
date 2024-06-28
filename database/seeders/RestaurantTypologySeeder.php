<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\RestaurantTypology;
use App\Models\Restaurant;
use App\Models\Typology;
class RestaurantTypologySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $all_restaurants = Restaurant::all();
        $all_typologies = Typology::all('id')->pluck('id')->toArray(); //->pluck('id')->toArray(); serve per restituire un array di id
        shuffle($all_typologies);
        
        foreach($all_restaurants as $restaurant) {
            for($index = 0; $index < rand(2,3); $index++) {
                $new_RestaurantTypology = new RestaurantTypology();
                $new_RestaurantTypology->restaurant_id = $restaurant->id;
                $new_RestaurantTypology->typology_id = $all_typologies[$index];
                $new_RestaurantTypology->save();
            }
         }
    }
}
