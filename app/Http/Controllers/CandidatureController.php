<?php

namespace App\Http\Controllers;

use App\Models\Formation;
use App\Models\Candidature;
use Illuminate\Http\Request;
use OpenApi\Annotations as OA;

/**
 * @OA\Info(title="My First API", version="0.1")
 * @OA\Tag(
 *     name="Candidature",
 *     description="Endpoints pour la gerer les candidature."
 * )
 * 
 * @OA\Server(url="127.0.0.1:8000/")
 */
class CandidatureController extends Controller
{

     /**
     * @OA\Post(
     *     path="/api/candidater",
     *      operationId="postuler",
     *      tags={"Candidature"},
     *      summary="Ajouter un candidature",
     *      description="Ajoute un nouveau candidature avec les détails fournis",
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="nomformation", type="string"),
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
    public function postuler(Request $request)
    {
        $request->validate([
            'nomformation' => 'required|string|exists:formations,nomformation',
        ]);
    
        $user = auth()->user();
        $nomFormation = $request->input('nomformation');
    
        $formation = Formation::where('nomformation', $nomFormation)->first();
    
        if ($formation) {
            if (!$user->candidatures()->where('formation_id', $formation->id)->exists()) {
                $candidature = $user->candidatures()->create([
                    'formation_id' => $formation->id,
                    // Ajoutez d'autres champs si nécessaire
                ]);
    
                return response(['message' => 'Candidature enregistrée avec succès'], 200);
            } else {
                return response(['error' => 'Vous avez déjà postulé à cette formation'], 400);
            }
        } else {
            return response(['error' => 'Formation non trouvée'], 404);
        }
    }

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
    public function accepterCandidature(Request $request, $id)
    {
        $candidature = Candidature::findOrFail($id);
        $candidature->update(['status' => 'accepter']);

        return response(['message' => 'Candidature acceptée avec succès'], 200);
    }


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
    public function refuserCandidature(Request $request, $id)
    {
        $candidature = Candidature::findOrFail($id);
        $candidature->update(['status' => 'refuser']);

        return response(['message' => 'Candidature refusée avec succès'], 200);
    }

     /**
     * @OA\Get(
     *      path="/api/candidatures",
     *      operationId="candidatures",
     *      tags={"Candidature"},
     *      summary="Tout les  candidature",
     *      description="la liste de tout les candidature ",
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="candidature", type="string"),
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="affichage Candidature avec succès",
     *      ),
     *      
     *      security={
     *          {"Bearer": {}}
     *      }
     * )
     */
    public function toutesLesCandidatures()
    {
        $candidatures = Candidature::all();

        return response(['candidatures' => $candidatures], 200);
    }



     /**
     * @OA\Get(
     *      path="/api/candidatures/acceptees",
     *      operationId="candidaturesAcceptees",
     *      tags={"Candidature"},
     *      summary="Tout les  candidature accepter",
     *      description="la liste de tout les candidature  accepter",
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="candidature", type="string"),
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Candidature accepter avec succès",
     *      ),
     *      
     *      security={
     *          {"Bearer": {}}
     *      }
     * )
     */

    public function candidaturesAcceptees()
    {
        $candidaturesAcceptees = Candidature::where('status', 'accepter')->get();

        return response(['candidatures_acceptees' => $candidaturesAcceptees], 200);
    }



     /**
     * @OA\Get(
     *      path="/api/candidatures/refusees",
     *      operationId="candidaturesRefusees",
     *      tags={"Candidature"},
     *      summary="Tout les  candidature refuser",
     *      description="la liste de tout les candidature  refuser",
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="candidature", type="string"),
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

    public function candidaturesRefusees()
    {
        $candidaturesRefusees = Candidature::where('status', 'refuser')->get();

        return response(['candidatures_refusees' => $candidaturesRefusees], 200);
    }


}

