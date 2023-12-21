<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use OpenApi\Annotations as OA;

/**
 * 
 * @OA\Tag(
 *     name="Candidature",
 *     description="Endpoints pour la gerer les candidature."
 * )
 * 
 * @OA\Server(url="127.0.0.1:8000/")
 */

class LoginAdminTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    // public function test_example(): void
    // {
    //     $response = $this->get('/');

    //     $response->assertStatus(200);
    // }

    /**
     * @OA\Post(
     *      path="/api/login",
     *      operationId="login",
     *      tags={"Utilisateurs"},
     *      summary="Connecter un utilisateur",
     *      description="Connexion d'un utilisteurs  avec les détails fournis",
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="email", type="string"),
     *              @OA\Property(property="password", type="string"),
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Utilisateur connecté avec succès"
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Informations invalid"
     *      ),
     * )
     */
    public function testConnexionReussie()
    {
        // Création d'un utilisateur
        $user = User::create([
            'nom' => 'sara',
            'prenom' => 'utshiwa',
            'email' => 'sarada@gmail.com',
            'password' => 123456789,
            'role_id' => 1,
          
            'adresse' => 'Dakar',
       
            // autres champs nécessaires
        ]);
    
        // Envoi de la requête de connexion
        $response = $this->postJson('/api/login', [
            'email' => 'sarada@gmail.com',
            'password' => 123456789,
        ]);
    
        // Vérifications
        $response->assertStatus(200);
        $this->assertArrayHasKey('token', $response->json());
    }
}
