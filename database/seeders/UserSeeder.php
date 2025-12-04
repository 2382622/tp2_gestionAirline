<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run()
    {
        // Un admin fixe
        User::create([
            'name'   => 'Admin',
            'prenom' => 'Test',
            'email'  => 'admin@example.com',
            'password' => bcrypt('maison123'),
            'role'   => 'admin',
            'email_verified_at' => now(),
        ]);

        // Des clients de démonstration avec le mot de passe "maison123"
        for ($i = 1; $i <= 10; $i++) {
            User::create([
                'name'   => "Client{$i}",
                'prenom' => "Test{$i}",
                'email'  => "client{$i}@example.com",
                'password' => bcrypt('maison123'),
                'role'   => 'client',
                'email_verified_at' => now(),
            ]);
        }

    }
}
