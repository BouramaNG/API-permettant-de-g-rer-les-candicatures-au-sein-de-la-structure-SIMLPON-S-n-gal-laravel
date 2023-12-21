<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class InscriptionCandidatTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    // public function test_example(): void
    // {
    //     $response = $this->get('/');

    //     $response->assertStatus(200);
    // }
    public function testInscriptionCandidatSucces()
{
    $response = $this->postJson('/api/ajoutercandidat', [
        'nom' => 'rokhaya',
        'prenom' => 'toure',
        'email' => 'rokhaya@gmail.com',
        'password' => 123456789,
        'role_id' => 2,
      
        'adresse' => 'Dakar',
        'niveau_etude' => 'Terminal',
    ]);

    $response->assertStatus(201)
             ->assertJson(['message' => 'Utilisateur ajouté avec succès']);
}

}
