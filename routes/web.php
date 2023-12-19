<?php

use App\Models\Formation;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\FormationController;
use App\Http\Controllers\CandidatureController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});


    Route::post('candidater',[CandidatureController::class,'postuler']);
    Route::post('/modifier/{id}',[FormationController::class,'update']);
    Route::get('deconnecter', [UserController::class, 'deconnect']);
    Route::delete('/formation/{id}', [FormationController::class, 'destroy']);
    Route::post('ajouter_formation',[FormationController::class,'AjouterFormation']);
    Route::post('/candidatures/{id}/accepter', [CandidatureController::class, 'accepterCandidature']);
    Route::post('/candidatures/{id}/refuser', [CandidatureController::class, 'refuserCandidature']);
    Route::get('/candidatures', [CandidatureController::class, 'toutesLesCandidatures']);
    Route::get('/candidatures/acceptees', [CandidatureController::class, 'candidaturesAcceptees']);
    Route::get('/candidatures/refusees', [CandidatureController::class, 'candidaturesRefusees']);


Route::post('login', [UserController::class, 'login']);
Route::post('/ajoutercandidat', [UserController::class, 'inscrirCandidat']);
Route::post('/ajouter-role', [UserController::class, 'ajouterRole']);
Route::post('/ajouter-utilisateur-admin', [UserController::class, 'ajouterUtilisateurAdmin']);
