<?php

use App\Http\Controllers\CandidatureController;
use App\Http\Controllers\FormationController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Models\Formation;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('auth:api')->group(function () {
    Route::post('candidater',[CandidatureController::class,'postuler']);
    Route::post('/modifier/{id}',[FormationController::class,'update']);
    Route::get('deconnecter', [UserController::class, 'deconnect']);
    Route::delete('/formation/{id}', [Formation::class, 'destroy']);
    Route::post('ajouter_formation',[FormationController::class,'AjouterFormation']);
    Route::post('/candidatures/{id}/accepter', [CandidatureController::class, 'accepterCandidature']);
    Route::post('/candidatures/{id}/refuser', [CandidatureController::class, 'refuserCandidature']);
    Route::get('/candidatures', [CandidatureController::class, 'toutesLesCandidatures']);
    Route::get('/candidatures/acceptees', [CandidatureController::class, 'candidaturesAcceptees']);
    Route::get('/candidatures/refusees', [CandidatureController::class, 'candidaturesRefusees']);
});

Route::post('login', [UserController::class, 'login']);
Route::post('/ajoutercandidat', [UserController::class, 'inscrirCandidat']);
Route::post('/ajouter-role', [UserController::class, 'ajouterRole']);
Route::post('/ajouter-utilisateur-admin', [UserController::class, 'ajouterUtilisateurAdmin']);