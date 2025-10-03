<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run()
    {
        // Un admin fixe
        User::factory()->create([
            'name'   => 'Admin',
            'prenom' => 'Test',
            'email'  => 'admin@example.com',
            'password' => bcrypt('123456'),
            'role'   => 'admin',
        ]);

    }
}
