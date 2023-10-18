<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Controller;
use App\Http\Controllers\PersonnelController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\TypeTournoiController;
use App\Http\Controllers\PhaseJeuController;
use App\Http\Controllers\TypeMatchController;
use App\Http\Controllers\EquipeController;
use App\Http\Controllers\TournoiController;
use App\Http\Controllers\EvenementController;
use App\Http\Controllers\TypeActiviteController;
use App\Http\Controllers\ActiviteController;
use App\Http\Controllers\LieuController;
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
Route::GET('Pronostiquer/{idtournoi}', [PersonnelController::class, 'Pronostiquer']);
Route::POST('/{idinscription}/{idtournoi}/addUPronostic', [PersonnelController::class, 'ajoutPronostic']);
Route::GET('statistique', [PersonnelController::class, 'Statistique']);

//Admin
Route::get('/LoginAdmin', function () {
    return view('Admin.LoginAdmin');
});
Route::POST('loginAdmin', [AdminController::class, 'loginAdmin']);
Route::GET('logoutAdmin', [AdminController::class, 'logoutAdmin']);
Route::GET('AdminStatistique', [AdminController::class, 'Statistique']);

//Type TOURNOI
Route::GET('TypeTournoi', [TypeTournoiController::class, 'liste']);
Route::POST('addTypeTournoi', [TypeTournoiController::class, 'ajouter']);
Route::POST('updateTypeTournoi/{idtypetournoi}',[TypeTournoiController::class, 'modifier']);
Route::POST('deleteTypeTournoi/{idtypetournoi}',[TypeTournoiController::class, 'supprimer']);

//Equipe
Route::GET('Equipe', [EquipeController::class, 'liste']);
Route::POST('addEquipe', [EquipeController::class, 'ajouter']);
Route::POST('updateEquipe/{idequipe}',[EquipeController::class, 'modifier']);
Route::POST('deleteEquipe/{idequipe}',[EquipeController::class, 'supprimer']);

//Période de pronostic
Route::GET('PeriodePronostic', [AdminController::class, 'PeriodePronostic']);
Route::POST('addPeriodePronostic', [AdminController::class, 'ajoutPeriodePronostic']);
Route::POST('updatePeriodePronostic',[AdminController::class, 'updatePeriodePronostic']);
Route::POST('deletePeriodePronostic',[AdminController::class, 'deletePeriodePronostic']);

//Phase de jeu
Route::GET('PhaseJeu', [PhaseJeuController::class, 'liste']);
Route::POST('addPhaseJeu', [PhaseJeuController::class, 'ajouter']);
Route::POST('updatePhaseJeu/{idphase}',[PhaseJeuController::class, 'modifier']);
Route::POST('deletePhaseJeu/{idphase}',[PhaseJeuController::class, 'supprimer']);

//Type MATCH
Route::GET('TypeMatch', [TypeMatchController::class, 'liste']);
Route::POST('addTypeMatch', [TypeMatchController::class, 'ajouter']);
Route::POST('updateTypeMatch/{idtypematch}',[TypeMatchController::class, 'modifier']);
Route::POST('deleteTypeMatch/{idtypematch}',[TypeMatchController::class, 'supprimer']);

//Tournoi
Route::GET('Tournoi', [tournoiController::class, 'liste']);
Route::POST('addTournoi', [tournoiController::class, 'ajouter']);
Route::POST('/FicheTournoi/updateTournoi',[tournoiController::class, 'modifier']);
Route::POST('deleteTournoi',[tournoiController::class, 'supprimer']);
Route::GET('FicheTournoi/{idtournoi}', [tournoiController::class, 'fiche']);

//Match
Route::GET('Match', [AdminController::class, 'Match']);
Route::POST('/{idtournoi}/addMatch', [AdminController::class, 'ajoutMatch']);
Route::POST('/{idtournoi}/addMatchCsv', [AdminController::class, 'ajoutMatchCsv']);
Route::POST('/{idtournoi}/updateMatch', [AdminController::class, 'updateMatch']);
Route::POST('/{idtournoi}/addResultatMatch', [AdminController::class, 'ajoutResultatMatch']);
Route::POST('deleteMatch',[AdminController::class, 'deleteMatch']);

//Type Activite
Route::GET('TypeActivite', [TypeActiviteController::class, 'liste']);
Route::POST('addTypeActivite', [TypeActiviteController::class, 'ajouter']);
Route::POST('updateTypeActivite/{idtypeactivite}',[TypeActiviteController::class, 'modifier']);
Route::POST('deleteTypeActivite/{idtypeactivite}',[TypeActiviteController::class, 'supprimer']);

//Activite
Route::GET('Activite', [ActiviteController::class, 'liste']);
Route::POST('addActivite', [ActiviteController::class, 'ajouter']);
Route::POST('updateActivite/{idactivite}',[ActiviteController::class, 'modifier']);
Route::POST('deleteActivite/{idactivite}',[ActiviteController::class, 'supprimer']);

//Lieu
Route::GET('Lieu', [LieuController::class, 'liste']);
Route::POST('addLieu', [LieuController::class, 'ajouter']);
Route::POST('updateLieu/{idlieu}',[LieuController::class, 'modifier']);
Route::POST('deleteLieu/{idlieu}',[EvenementController::class, 'supprimer']);

//Evenement
Route::GET('Evenement', [EvenementController::class, 'liste']);
Route::POST('addEvenement', [EvenementController::class, 'ajouter']);
Route::GET('ficheEvenement/{idevenement}', [EvenementController::class, 'fiche']);
Route::POST('/{idevenement}/addActiviteEvenement', [EvenementController::class, 'ajouterActivite']);
Route::POST('/{idevenement}/updateActiviteEvenement', [EvenementController::class, 'modifierActivite']);
Route::GET('detailActivite', [EvenementController::class, 'detailActivite']);

