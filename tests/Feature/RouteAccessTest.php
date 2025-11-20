<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RouteAccessTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function la_page_daccueil_est_accessible()
    {
        // Vérifie qu'un visiteur non authentifié peut charger la page d'accueil.
        $response = $this->get(route('accueil'));

        $response->assertOk()
            ->assertViewIs('accueil.index');
    }

    /** @test */
    public function un_admin_peut_acceder_a_la_page_de_gestion_des_tickets()
    {
        // Prépare un utilisateur avec le rôle administrateur.
        $admin = User::factory()->create(['role' => 'admin']);

        // L'admin doit accéder sans erreur à la liste des tickets.
        $response = $this->actingAs($admin)->get(route('admin.tickets.index'));

        $response->assertOk()
            ->assertViewIs('admin.tickets.index');
    }

    /** @test */
    public function un_client_connecte_ne_peut_pas_acceder_aux_tickets_admin()
    {
        // Un utilisateur standard ne possède pas les droits d'administration.
        $client = User::factory()->create(['role' => 'client']);

        // Le middleware admin doit renvoyer une réponse 403.
        $response = $this->actingAs($client)->get(route('admin.tickets.index'));

        $response->assertForbidden();
    }

    /** @test */
    public function un_invite_est_redirige_vers_la_connexion_pour_une_route_admin()
    {
        // Un visiteur non connecté doit être redirigé vers la page de connexion.
        $response = $this->get(route('admin.tickets.index'));

        $response->assertRedirect(route('login'));
    }
}
