<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Generator as Faker;
use App\Models\Restaurant;
use App\Models\User;
use App\Functions\Helpers;

class RestaurantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(Faker $faker): void
    {
        $restaurants = json_decode(file_get_contents(__DIR__ . DIRECTORY_SEPARATOR . 'json' . DIRECTORY_SEPARATOR .  'Restaurants.json'));
        $users = User::all('id')->pluck('id')->toArray(); //->pluck('id')->toArray(); serve per restituire un array di id

        shuffle($users); //li mischia randomicamente

        if (count($users) < count($restaurants)) {
            throw new \Exception('There are not enough users to create all the restaurants');
        }

        foreach ($restaurants as $index => $restaurant) {
            $new_Restaurant = new Restaurant();
            $new_Restaurant->name = $restaurant->Name;
            $new_Restaurant->address = $restaurant->Address;
            $new_Restaurant->image = $restaurant->image;
            $new_Restaurant->VAT = $restaurant->VAT;
            $new_Restaurant->phone = $faker->phoneNumber();
            $new_Restaurant->slug = Helpers::generateSlug($restaurant->Name, Restaurant::class);
            $new_Restaurant->user_id = $users[$index];
            $new_Restaurant->save();
        }
    }
}
