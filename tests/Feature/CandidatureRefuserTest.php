<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Candidature;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use OpenApi\Annotations as OA;


/**
 * @OA\Info(title="My First API", version="0.1")
 * @OA\Tag(
 *     name="CandidatureRefuser",
 *     description="Endpoints pour la gerer les candidature."
 * )
 * 
 * @OA\Server(url="127.0.0.1:8000/")
 */
class CandidatureRefuserTest extends TestCase
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
     *      path="/api/candidatures/{id}/refuser",
     *      operationId="refuserCandidature",
     *      tags={"Candidature"},
     *      summary="refuser un candidature",
     *      description="vous avez refuser la candidature avec succe ",
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="status", type="enum"),
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Candidature refuser avec succès",
     *      ),
     *      
     *      security={
     *          {"Bearer": {}}
     *      }
     * )
     */
  
    public function testCandidaturesRefuse()
    {
        $candidaturesAcceptees = Candidature::where('status', 'refuser')->get();

       
       
        $response = $this->get('/api/candidatures/refusees');

        // Vérifiez que la réponse est correcte
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'candidatures_refusees' => [
                '*' => [ 'id', 'status']
            ]
        ]);
    }
}
