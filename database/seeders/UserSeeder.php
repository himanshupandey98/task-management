<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create a user
        $user = User::updateOrCreate(
            ['email' => 'admin@test.com'], // Ensure the user is unique
            [
                'name' => 'Admin',
                'email' => 'admin@test.com',
                'password' => Hash::make('1234567890'),
            ]
        );

        $this->command->info('user created successfully');
    }
}
