<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = json_decode(file_get_contents(__DIR__ . DIRECTORY_SEPARATOR . 'json' . DIRECTORY_SEPARATOR . 'users.json'));
        foreach ($users as $user) {
            $new_user = new User();
            $new_user->name = $user->name;
            $new_user->lastname = $user->lastname;
            $new_user->email = $user->email;
            $new_user->slug = User::generateSlug($user->name, $user->lastname);
            $new_user->password = $user->password;
            $new_user->save();
        }
    }
}
/* $restaurants = jsondecode(fileget_contents(__DIR . DIRECTORY_SEPARATOR . 'json' . DIRECTORY_SEPARATOR . 'Restaurants.json')); */