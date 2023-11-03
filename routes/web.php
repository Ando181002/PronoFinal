<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Controller;
use App\Http\Controllers\AuthentificationController;
use App\Http\Controllers\CompteController;
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
use App\Http\Controllers\PeriodePronosticController;
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
    return view('Accueil.Accueil');
});
Route::GET('Pronostics', [PersonnelController::class, 'Accueil']);
Route::GET('login', [AuthentificationController::class, 'Login']);
Route::POST('traitementLogin', [AuthentificationController::class, 'TraitementLogin']);
//Personnel
Route::GET('creerCompte', [CompteController::class, 'CreerCompte']);
Route::POST('traitementInscription', [CompteController::class, 'TraitementInscription']);
Route::GET('reinitialisationMdp/{trigramme}', [CompteController::class, 'Reinitialisation']);
Route::POST('reinitialisationMdp/reinitialiser', [CompteController::class, 'Reinitialiser']);
Route::GET('deconnexion', [PersonnelController::class, 'Deconnexion']);
Route::GET('liste', [PersonnelController::class, 'Liste']);
Route::GET('detailTournoi', [PersonnelController::class, 'DetailTournoi']);
Route::GET('participerPronostic/{idtournoi}/{erreur}', [PersonnelController::class, 'formulaireParticipation']);
Route::POST('participer', [PersonnelController::class, 'Participer']);
Route::GET('Pronostiquer/{idtournoi}', [PersonnelController::class, 'Pronostiquer']);
Route::POST('/{idinscription}/{idtournoi}/addUPronostic', [PersonnelController::class, 'ajoutPronostic']);
Route::GET('statistique', [PersonnelController::class, 'Statistique']);

//Admin
Route::GET('logoutAdmin', [AdminController::class, 'logoutAdmin']);
Route::GET('AdminStatistique', [AdminController::class, 'Statistique']);
Route::GET('pdf', [AdminController::class, 'genererPdf']);
Route::GET('exportCsv', [AdminController::class, 'exportCsv']);

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
Route::GET('PeriodePronostic', [PeriodePronosticController::class, 'liste']);
Route::POST('addPeriodePronostic', [PeriodePronosticController::class, 'ajouter']);
Route::POST('updatePeriodePronostic/{idperiode}',[PeriodePronosticController::class, 'modifier']);

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
Route::GET('Tournoi', [TournoiController::class, 'liste']);
Route::POST('addTournoi', [TournoiController::class, 'ajouter']);
Route::GET('deleteTournoi/{idtournoi}',[TournoiController::class, 'supprimer']);
Route::POST('/FicheTournoi/updateTournoi/{idtournoi}',[TournoiController::class, 'modifier']);
Route::GET('FicheTournoi/{idtournoi}', [TournoiController::class, 'fiche']);
Route::GET('FicheTournoi/pdf/{idtournoi}/{idphase}', [TournoiController::class, 'genererPdf']);
Route::GET('FicheTournoi/exportCsv/{idtournoi}/{idphase}', [TournoiController::class, 'exportCsv']);

//Match
Route::POST('/{idtournoi}/addMatch', [TournoiController::class, 'ajouterMatch']);
Route::POST('/{idtournoi}/addMatchCsv', [TournoiController::class, 'ajouterMatchCsv']);
Route::POST('/{idtournoi}/{idmatch}/updateMatch', [TournoiController::class, 'modifierMatch']);
Route::GET('/{idtournoi}/{idmatch}/deleteMatch', [TournoiController::class, 'supprimerMatch']);
Route::POST('/{idtournoi}/addResultatMatch', [TournoiController::class, 'ajoutResultatMatch']);

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
Route::POST('/evenement/updateEvenement/{idevenement}', [EvenementController::class, 'modifier']);
Route::GET('ficheEvenement/{idevenement}', [EvenementController::class, 'fiche']);
Route::POST('/{idevenement}/addActiviteEvenement', [EvenementController::class, 'ajouterActivite']);
Route::POST('/{idevenement}/{idevenement_activite}/updateActiviteEvenement', [EvenementController::class, 'modifierActivite']);
Route::GET('/{idevenement}/{idevenement_activite}/deleteActiviteEvenement', [EvenementController::class, 'effacerActivite']);

Route::GET('listeEvenement', [EvenementController::class, 'listeEvenement']);
Route::GET('detailEvenement/{idevenement}', [EvenementController::class, 'detailEvenement']);
Route::GET('detailEvenement/detailActivite', [EvenementController::class, 'detailActivite']);

