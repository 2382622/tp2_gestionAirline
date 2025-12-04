<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Avion;

class AvionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Quelques avions de démonstration
        Avion::create([
            'modele'   => 'Boeing 737',
            'capacite' => 180,
        ]);

        Avion::create([
            'modele'   => 'Airbus A320',
            'capacite' => 200,
        ]);

        Avion::create([
            'modele'   => 'Boeing 777',
            'capacite' => 350,
        ]);
    }
}
