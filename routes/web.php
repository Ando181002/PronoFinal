<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Controller;
use App\Http\Controllers\PersonnelController;
use App\Http\Controllers\AdminController;
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

//Personnel
Route::GET('/', [PersonnelController::class, 'Accueil']);
Route::GET('detailTournoi', [PersonnelController::class, 'DetailTournoi']);
Route::GET('creerCompte', [PersonnelController::class, 'CreerCompte']);
Route::POST('traitementInscription', [PersonnelController::class, 'TraitementInscription']);
Route::GET('reinitialisationMdp/{trigramme}', [PersonnelController::class, 'Reinitialisation']);
Route::POST('reinitialisationMdp/reinitialiser', [PersonnelController::class, 'Reinitialiser']);
Route::GET('login', [PersonnelController::class, 'Login']);
Route::POST('traitementLogin', [PersonnelController::class, 'TraitementLogin']);
Route::GET('deconnexion', [PersonnelController::class, 'Deconnexion']);
Route::GET('liste', [PersonnelController::class, 'Liste']);
Route::GET('participerPronostic/{idtournoi}/{erreur}', [PersonnelController::class, 'formulaireParticipation']);
Route::POST('participer', [PersonnelController::class, 'Participer']);
Route::GET('Pronostiquer/{idtournoi}', [UtilisateurController::class, 'Pronostiquer']);
Route::POST('/{idparticipant}/{idtournoi}/addUPronostic', [UtilisateurController::class, 'ajoutPronostic']);
Route::GET('statistique', [PersonnelController::class, 'Statistique']);

//Admin
Route::get('/LoginAdmin', function () {
    return view('Admin.LoginAdmin');
});
Route::POST('loginAdmin', [AdminController::class, 'loginAdmin']);
Route::GET('logoutAdmin', [AdminController::class, 'logoutAdmin']);
Route::GET('AdminStatistique', [AdminController::class, 'Statistique']);

//Type TOURNOI
Route::GET('TypeTournoi', [AdminController::class, 'TypeTournoi']);
Route::POST('addTypeTournoi', [AdminController::class, 'ajoutTypeTournoi']);
Route::POST('updateTypeTournoi',[AdminController::class, 'updateTypeTournoi']);
Route::POST('deleteTypeTournoi',[AdminController::class, 'deleteTypeTournoi']);

//Equipe
Route::GET('Equipe', [AdminController::class, 'Equipe']);
Route::POST('addEquipe', [AdminController::class, 'ajoutEquipe']);
Route::POST('updateEquipe',[AdminController::class, 'updateEquipe']);
Route::POST('deleteEquipe',[AdminController::class, 'deleteEquipe']);

//Période de pronostic
Route::GET('PeriodePronostic', [AdminController::class, 'PeriodePronostic']);
Route::POST('addPeriodePronostic', [AdminController::class, 'ajoutPeriodePronostic']);
Route::POST('updatePeriodePronostic',[AdminController::class, 'updatePeriodePronostic']);
Route::POST('deletePeriodePronostic',[AdminController::class, 'deletePeriodePronostic']);

//Phase de jeu
Route::GET('PhaseJeu', [AdminController::class, 'PhaseJeu']);
Route::POST('addPhaseJeu', [AdminController::class, 'ajoutPhaseJeu']);
Route::POST('updatePhaseJeu',[AdminController::class, 'updatePhaseJeu']);
Route::POST('deletePhaseJeu',[AdminController::class, 'deletePhaseJeu']);

//Type MATCH
Route::GET('TypeMatch', [AdminController::class, 'TypeMatch']);
Route::POST('addTypeMatch', [AdminController::class, 'ajoutTypeMatch']);
Route::POST('updateTypeMatch',[AdminController::class, 'updateTypeMatch']);
Route::POST('deleteTypeMatch',[AdminController::class, 'deleteTypeMatch']);

//Tournoi
Route::GET('Tournoi', [AdminController::class, 'Tournoi']);
Route::GET('FicheTournoi/{idtournoi}', [AdminController::class, 'FicheTournoi']);
Route::POST('addTournoi', [AdminController::class, 'ajoutTournoi']);
Route::POST('/FicheTournoi/updateTournoi',[AdminController::class, 'UpdateTournoi']);
Route::POST('deleteTournoi',[AdminController::class, 'deleteTournoi']);

//Match
Route::GET('Match', [AdminController::class, 'Match']);
Route::POST('/{idtournoi}/addMatch', [AdminController::class, 'ajoutMatch']);
Route::POST('/{idtournoi}/addMatchCsv', [AdminController::class, 'ajoutMatchCsv']);
Route::POST('/{idtournoi}/updateMatch', [AdminController::class, 'updateMatch']);
Route::POST('/{idtournoi}/addResultatMatch', [AdminController::class, 'ajoutResultatMatch']);
Route::POST('deleteMatch',[AdminController::class, 'deleteMatch']);


