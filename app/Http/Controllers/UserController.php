<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Validator;
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
class UserController extends Controller
{


     /**
     * @OA\Post(
     *     path="/api/ajouter-role",
     *      operationId="ajouterRole",
     *      tags={"User"},
     *      summary="Ajouter un role",
     *      description="Ajoute un nouveau role avec les détails fournis",
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="nomRole", type="string"),
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="ajout role  avec succès",
     *      ),
     *      
     *      security={
     *          {"Bearer": {}}
     *      }
     * )
     */
    public function ajouterRole(Request $request)
    {
        $request->validate([
            'nomRole' => 'required|string|unique:roles',
        ]);

        $role = Role::create([
            'nomRole' => $request->nomRole,
        ]);

        return response()->json(['message' => 'Rôle ajouté avec succès', 'role' => $role], 201);
    }



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
     *              @OA\Property(property="nom", type="string"),
     *              @OA\Property(property="prenom", type="string"),
     *              @OA\Property(property="email", type="string"),
     *              @OA\Property(property="password", type="string"),
     *              @OA\Property(property="adresse", type="string"),
     *              
     *            
     *            
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Candidat inscrit avec succès"
     *      ),
     * 
     * )
     */
    public function inscrirCandidat(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nom' => ['required', 'string', 'min:4', 'regex:/^[a-zA-Z]+$/'],
            'prenom' => ['required', 'string', 'min:4', 'regex:/^[a-zA-Z]+$/'],
            'email' => ['required', 'email', 'unique:users,email'],
    
            'adresse' => ['required', 'string', 'regex:/^[a-zA-Z0-9 ]+$/'],
           
           
        ]);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

       
        $roleCandidate = Role::where('nomRole', 'candidat')->first();
        $user = User::create([
            'nom' => $request->nom,
            'prenom' => $request->prenom,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'adresse' => $request->adresse,
            'niveau_etude' => $request->niveau_etude,
            'date_naissance' => $request->date_naissance,
            'role_id' => $roleCandidate->id,
         
        ]);

        $user->roles()->attach($roleCandidate);

        return response()->json(['message' => 'Utilisateur ajouté avec succès'], 201);
    }


  /**
     * @OA\Post(
     *      path="/api/ajouter-utilisateur-admin",
     *      operationId="ajouterUtilisateurAdmin",
     *      tags={"Utilisateurs"},
     *      summary="Inscrire un admin",
     *      description="Inscription d'un admin  avec les détails fournis",
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="nom", type="string"),
     *              @OA\Property(property="prenom", type="string"),
     *              @OA\Property(property="email", type="string"),
     *              @OA\Property(property="password", type="string"),
     *       
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Admin inscrit avec succès"
     *      ),
     * )
     */

    public function ajouterUtilisateurAdmin(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nom' => 'required|string|min:2|regex:/^[a-zA-Z]+$/',
            'prenom' => 'required|string|min:4|regex:/^[a-zA-Z]+$/',
            'email' => 'required|email|unique:users,email',
           
        ]);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
      

        $roleAdmin = Role::where('nomRole', 'admin')->first();

        $user = User::create([
            'nom' => $request->nom,
            'prenom' => $request->prenom,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'adresse' => $request->adresse,
       
            'role_id' => $roleAdmin->id,
            
        ]);

        $user->roles()->attach($roleAdmin);

        return response()->json(['message' => 'Admin ajouté avec succès'], 201);
    }


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
    public function login(Request $request)
    {

        // data validation
        $validator = Validator::make($request->all(), [
            "email" => "required|email",
         
        ]);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // JWTAuth
        $token = JWTAuth::attempt([
            "email" => $request->email,
            "password" => $request->password
        ]);

        if (!empty($token)) {
       $user = Auth::user();
            return response()->json([
                "status" => true,
                "message" => "utilisateur connecter avec succe",
                "token" => $token,
                'user'=>$user
            ]);
        }

        return response()->json([
            "status" => false,
            "message" => "details invalide"
        ]);
    }


     /**
     * @OA\Post(
     *      path="/api/deconnecter",
     *      operationId="logout",
     *      tags={"Utilisateurs"},
     *      summary="Deconnecter un utilisateur",
     *      description="Deconnexion d'un utilisteurs  et invalidation de son token jwt",
     *      @OA\Response(
     *          response=200,
     *          description="Utilisateur deconnecté  avec succès"
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Aucun utilisateur connecté"
     *      ),
     *      security={
     *         {"Bearer": {}}
     *      }
     * )
     */
    public function deconnect()
    {
        //J'utilise la façade Auth pour faire la deconnexion
        Auth::logout();
        session()->invalidate();

        session()->regenerateToken();

        return redirect('/');
    }
}
