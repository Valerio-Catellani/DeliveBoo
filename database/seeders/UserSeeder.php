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
        $users = json_decode(file_get_contents(__DIR__ . '\json\users.json'));
        foreach ($users as $user) {
            $new_user = new User();
            $new_user->name = $user->name;
            $new_user->lastname = $user->lastname;
            $new_user->email = $user->email;
            $new_user->password = $user->password;
            $new_user->save();
        }
    }
}
