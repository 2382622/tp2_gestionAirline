<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Ticket;
use App\Models\User;
use App\Models\Vol;

class TicketSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = User::where('role', 'client')->get();
        $vols  = Vol::all();

        if ($users->isEmpty() || $vols->isEmpty()) {
            return;
        }

        // Pour chaque user client, on lui assigne quelques tickets sur des vols
        foreach ($users as $user) {
            $assignedVols = $vols->random(min(3, $vols->count()));

            foreach ($assignedVols as $vol) {
                Ticket::create([
                    'vol_id'   => $vol->id,
                    'user_id'  => $user->id,
                    'quantite' => rand(1, 3),
                ]);
            }
        }
    }
}
