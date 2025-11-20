<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Avion;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class CreationVolTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function un_admin_peut_creer_un_vol_avec_photo()
    {
        // Storage simulé
        Storage::fake('public');

        // un admin + un avion
        $admin = User::factory()->create(['role' => 'admin']);
        $avion = Avion::factory()->create(['modele' => 'Airbus A320']);

        // Données valides
        $payload = [
            'id' => 'MTL-PAR-999',
            'origine' => 'montréal',
            'destination' => 'paris',
            'date_depart' => now()->addDays(7)->format('Y-m-d'),
            'date_arrive' => now()->addDays(8)->format('Y-m-d'),
            'prix' => 4120.50,
            'avion_id' => $avion->id,
            'photo' => UploadedFile::fake()->image('MTL-PAR.jpg', 800, 450),
        ];


        $res = $this->actingAs($admin)->post(route('vols.store'), $payload);

        // Assert
        $res->assertRedirect(route('vols.index'));
        $this->assertDatabaseHas('vols', [
            'id' => 'MTL-PAR-999',
            'origine' => 'montréal',
            'destination' => 'paris',
            'avion_id' => $avion->id,
        ]);

        // Le fichier est bien "uploadé" dans le disque fake
        Storage::disk('public')->assertExists('images/upload/' . $payload['photo']->hashName());
    }
}
