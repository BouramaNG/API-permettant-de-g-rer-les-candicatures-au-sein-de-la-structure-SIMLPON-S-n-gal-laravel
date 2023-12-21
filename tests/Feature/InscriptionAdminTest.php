<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class InscriptionAdminTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    // public function test_example(): void
    // {
    //     $response = $this->get('/');

    //     $response->assertStatus(200);
    // }
    public function testInscriptionAdminSucces()
    {
        $response = $this->postJson('/api/ajouter-utilisateur-admin', [
            'nom' => 'rokhayaa',
            'prenom' => 'touree',
            'email' => 'rokhaya9@gmail.com',
            'password' => '123456789', 
            'role_id' => 1,
            'adresse' => 'dakar',
        ]);
    
        $response->assertStatus(201)
                 ->assertJson(['message' => 'Admin ajouté avec succès admin']); 
    }
    
}
