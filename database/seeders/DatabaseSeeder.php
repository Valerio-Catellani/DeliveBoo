<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\RestaurantTypology;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        $this->call([
            UserSeeder::class,
            TypologySeeder::class,
            RestaurantSeeder::class,
            RestaurantTypologySeeder::class,
            DishSeeder::class,
            OrderSeeder::class,
            DishOrderSeeder::class,
        ]);
        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
