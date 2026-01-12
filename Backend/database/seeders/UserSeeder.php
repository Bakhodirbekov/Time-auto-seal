<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Create Admin User
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@insofauto.com',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
            'phone' => '+998901234567',
            'is_blocked' => false,
        ]);

        // Create Moderator User
        User::create([
            'name' => 'Moderator User',
            'email' => 'moderator@insofauto.com',
            'password' => Hash::make('moderator123'),
            'role' => 'moderator',
            'phone' => '+998901234568',
            'is_blocked' => false,
        ]);

        // Create Test User
        User::create([
            'name' => 'Test User',
            'email' => 'user@insofauto.com',
            'password' => Hash::make('user123'),
            'role' => 'user',
            'phone' => '+998901234569',
            'is_blocked' => false,
        ]);
    }
}
