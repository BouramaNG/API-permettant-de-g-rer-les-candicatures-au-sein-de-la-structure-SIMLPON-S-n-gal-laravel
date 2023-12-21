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
class AdressEmailUniqueTest extends TestCase
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
     *     path="/api/ajoutercandidat",
     *      operationId="testEmailUniqueCandida",
     *      tags={"Adress email unique"},
     *      summary="Gerer les adress unique",
     *      description="Gerer les adress unique avec les détails fournis",
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="adressunique", type="string"),
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Candidature créé avec succès",
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="formation non trouve",
     *      ),
     *      security={
     *          {"Bearer": {}}
     *      }
     * )
     */

    public function testEmailUniqueCandidat()
{
    $candidat1 = User::create([
        'nom' => 'bourama',
        'email' => 'adama@gmail.com',
        'password' => 123456789,
        'role_id' => 2,
        'prenom' => 'ngom',
        'adresse' => 'Dakar',
        'niveau_etude' => 'Terminal',
      
    ]);
    $candidat2 = ['email' => $candidat1->email, ]; 

    $response = $this->post('/api/ajoutercandidat', $candidat2);

    $response->assertStatus(422); 
}
}
