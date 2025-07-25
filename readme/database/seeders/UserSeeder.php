<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Administrateur principal
        User::create([
            'name' => 'Admin ReadMe',
            'email' => 'admin@readme.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        // Utilisateur de test
        User::create([
            'name' => 'Utilisateur',
            'email' => 'user@readme.com',
            'password' => Hash::make('password'),
            'role' => 'user',
        ]);

        // Quelques utilisateurs supplémentaires
        $users = [
            ['name' => 'Marie Leclerc', 'email' => 'marie@test.com'],
            ['name' => 'Pierre Durand', 'email' => 'pierre@test.com'],
            ['name' => 'Sophie Martin', 'email' => 'sophie@test.com'],
            ['name' => 'Lucas Bernard', 'email' => 'lucas@test.com'],
            ['name' => 'Emma Petit', 'email' => 'emma@test.com'],
        ];

        foreach ($users as $userData) {
            User::create([
                'name' => $userData['name'],
                'email' => $userData['email'],
                'password' => Hash::make('password'),
                'role' => 'user',
            ]);
        }
    }
}
