<?php

namespace Database\Seeders;

use App\Models\Profile;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'role' => 'admin',
            'password' => Hash::make('12345'),
        ]);

        Profile::factory()->create([
            'username' => 'admin Bat',
            'age' => 24,
            'gender' => 'male',
            'user_id' => 1,
            'profile_pic' => null
        ]);

        // User::factory(9)->create();



        $this->call(
            [
                CategorySeeder::class,
                PostSeeder::class
            ]
        );
    }
}
