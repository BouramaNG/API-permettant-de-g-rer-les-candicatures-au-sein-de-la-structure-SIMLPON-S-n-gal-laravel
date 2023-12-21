<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
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
class PrenomTest extends TestCase
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
     *      path="/api/ajoutercandidat",
     *      operationId="inscrirCandidat",
     *      tags={"Utilisateurs"},
     *      summary="Inscrire un candidat ",
     *      description="Inscription d'un candidat  avec les détails fournis",
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(
     *              type="object",
     *           
     *              @OA\Property(property="prenom", type="string"),
     *        
     *            
     *              
     *            
     *            
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Prenom inscrit avec succès"
     *      ),
     * 
     * )
     */
    public function testPrenomStringCandidat()
{
    $response = $this->get('/api/liste_user', ['prenom' => 12345]);

    $response->assertStatus(200);
}
}
