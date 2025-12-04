<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Vol;
use App\Models\Avion;
use Illuminate\Support\Str;

class VolSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $avions = Avion::all();

        if ($avions->isEmpty()) {
            return;
        }

        // Crée quelques vols simples répartis sur les avions existants
        $routes = [
            ['origine' => 'Montreal', 'destination' => 'Paris'],
            ['origine' => 'Montreal', 'destination' => 'New York'],
            ['origine' => 'Paris',    'destination' => 'Rome'],
            ['origine' => 'Toronto',  'destination' => 'Vancouver'],
        ];

        $index = 1;
        foreach ($routes as $route) {
            foreach ($avions as $avion) {
                $depart = now()->addDays($index);
                $arrive = (clone $depart)->addHours(6);

                Vol::create([
                    'id'          => 'V' . str_pad($index, 4, '0', STR_PAD_LEFT),
                    'date_depart' => $depart,
                    'date_arrive' => $arrive,
                    'origine'     => $route['origine'],
                    'destination' => $route['destination'],
                    'prix'        => 350 + ($index * 10),
                    'efface'      => 0,
                    'avion_id'    => $avion->id,
                    // Valeur par dÃ©faut non nulle pour respecter la contrainte NOT NULL
                    'photo'       => 'default_vol.jpg',
                ]);

                $index++;
            }
        }
    }
}
