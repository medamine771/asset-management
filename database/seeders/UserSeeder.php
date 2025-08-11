<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Compte Admin
        User::create([
            'name' => 'Admin Test',
            'email' => 'admin@test.com',
            'password' => Hash::make('password123'), // Mot de passe : password123
            'role' => 'admin',
        ]);

        // Compte Technicien
        User::create([
            'name' => 'Technicien Test',
            'email' => 'technicien@test.com',
            'password' => Hash::make('password123'), // Mot de passe : password123
            'role' => 'technicien',
        ]);
    }
}
