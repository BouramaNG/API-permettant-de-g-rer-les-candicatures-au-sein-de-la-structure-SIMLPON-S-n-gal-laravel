<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Candidature;
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
class CandidatureAccepterTest extends TestCase
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
     *      path="/api/candidatures/{id}/accepter",
     *      operationId="accepterCandidatur",
     *      tags={"Candidature"},
     *      summary="Ajouter un candidature",
     *      description="vous avez accepter la candidature avec succe ",
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="status", type="enum"),
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Candidature acceptée avec succès",
     *      ),
     *      
     *      security={
     *          {"Bearer": {}}
     *      }
     * )
     */
    public function testCandidaturesAcceptees()
    {
        $candidaturesAcceptees = Candidature::where('status', 'accepter')->get();

       
       
        $response = $this->get('/api/candidatures/acceptees');

        // Vérifiez que la réponse est correcte
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'candidatures_acceptees' => [
                '*' => [ 'id', 'nom', 'status']
            ]
        ]);
    }
}

