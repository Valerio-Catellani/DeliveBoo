<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Restaurant;
use App\Models\User;

class RestaurantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $restaurants = json_decode(file_get_contents(__DIR__ . '\json\Restaurants.json'));
        $user = User::all('id')->pluck('id')->toArray(); //->pluck('id')->toArray(); serve per restituire un array di id

        shuffle($user); //li mischia randomicamente

        if (count($user) < count($restaurants)) {
            throw new \Exception('There are not enough users to create all the restaurants');
        }

        foreach ($restaurants as $index => $restaurant) {
            $new_Restaurant = new Restaurant();
            $new_Restaurant->name = $restaurant->Name;
            $new_Restaurant->address = $restaurant->Address;
            $new_Restaurant->image = $restaurant->image;
            $new_Restaurant->VAT = $restaurant->VAT;
            $new_Restaurant->user_id = $user[$index];
            $new_Restaurant->save();
        }
    }
}
