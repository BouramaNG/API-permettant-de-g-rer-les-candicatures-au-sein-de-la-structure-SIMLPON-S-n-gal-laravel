<?php

namespace App\Http\Controllers;

use App\Models\Formation;
use Illuminate\Http\Request;
use OpenApi\Annotations as OA;

/**
 *
 * @OA\Tag(
 *     name="Formation",
 *     description="Endpoints pour la gerer les formations."
 * )
 * 
 * @OA\Server(url="127.0.0.1:8000/")
 */
class FormationController extends Controller
{
     /**
     * @OA\Post(
     *     path="/api/ajouter_formation",
     *      operationId="AjouterFormation",
     *      tags={"Formation"},
     *      summary="Ajouter un formation",
     *      description="Ajoute un nouveau formation avec les détails fournis",
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="nomformation", type="string"),
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Formation créé avec succès",
     *      ),
     *      
     *      security={
     *          {"Bearer": {}}
     *      }
     * )
     */
    public function AjouterFormation(Request $request)
    {
 
        $request->validate([
            'nomformation' => 'required|string',
            'description' => 'required|string',
            'date_debut' => 'required|date',
            'durer_formation' => 'required|string',
            'niveau' => 'required|string',
            'place_disponible' => 'required|integer',
            'domaine_formation' => 'required|string',
        ]);

        $formation = Formation::create([
            'nomformation' => $request->input('nomformation'),
            'description' => $request->input('description'),
            'date_debut' => $request->input('date_debut'),
            'durer_formation' => $request->input('durer_formation'),
            'niveau' => $request->input('niveau'),
            'place_disponible' => $request->input('place_disponible'),
            'domaine_formation' => $request->input('domaine_formation'),
        ]);

        return response(['message' => 'Formation créée avec succès', 'formation' => $formation], 201);
    }



     /**
     * @OA\Post(
     *      path="/api/formation/{id}",
     *      operationId="destroy",
     *      tags={"Formation"},
     *      summary="Supprimer un formation",
     *      description="Supprime un formation en fonction de l'ID fourni",
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="id", type="integer"),
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="formation supprimé avec succès",
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Non autorisé",
     *      ),
     *      security={
     *         {"Bearer": {}}
     *      }
     * )
     */

    public function destroy($id)
    {

        if (!auth()->check() || auth()->user()->role_id !==1 ) {
            return response()->json(['message' => 'Non autorisé'], 401);
        }


        $formation = Formation::find($id);

        if (!$formation ) {
            return response()->json(['message' => 'formation not found'], 404);
        }

        $formation ->delete();

        return response()->json(['message' => 'formation deleted successfully'], 200);
    }



     /**
     * @OA\Post(
     *      path="/api/modifier/{id}",
     *      operationId="update",
     *      tags={"Formation"},
     *      summary="Modifier un formation",
     *      description="Modifier un formation en fonction de l'ID fourni",
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="id", type="integer"),
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="formation Modifieravec succès",
     *      ),
     *     
     *      security={
     *         {"Bearer": {}}
     *      }
     * )
     */

    public function update(Request $request, $id)
    {
        // Validation des données de la requête
        $request->validate([
            'nomformation' => 'required|string',
            'description' => 'required|string',
            'date_debut' => 'required|date',
            'durer_formation' => 'required|string',
            'niveau' => 'required|string',
            'place_disponible' => 'required|integer',
            'domaine_formation' => 'required|string',
        ]);

        $formation = Formation::findOrFail($id);

       
        $formation->update([
            'nomformation' => $request->input('nomformation'),
            'description' => $request->input('description'),
            'date_debut' => $request->input('date_debut'),
            'durer_formation' => $request->input('durer_formation'),
            'niveau' => $request->input('niveau'),
            'place_disponible' => $request->input('place_disponible'),
            'domaine_formation' => $request->input('domaine_formation'),
        ]);

        return response(['message' => 'Formation mise à jour avec succès', 'formation' => $formation], 200);
    }
}
