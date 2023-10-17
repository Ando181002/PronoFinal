<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\PhaseJeu;

class PhaseJeuController extends Controller
{
    public function liste(){
        $phasesJeu=PhaseJeu::all();
        return view('Admin.PhaseJeu',compact('phasesJeu'));
    }

    public function ajouter(Request $req){
        $validation=PhaseJeu::reglesValidation('creation');
        $req->validate($validation['regles'],$validation['messages']);
        PhaseJeu::ajouterPhaseJeu($req->input('nomphase'));
        return redirect('PhaseJeu');
    }

    public function modifier(Request $req,$idphase){
        $phaseJeu=PhaseJeu::find($idphase);
        if(!$phaseJeu){
            return redirect()->route('PhaseJeu')->with('error','Phase de jeu non trouvée.');
        }
        $validation=TypeTournoi::reglesValidation('modification');
        $req->validate($validation['regles'],$validation['messages']);
        $phaseJeu->modifierPhaseJeu($req->input('nomphase'));
        return redirect('PhaseJeu');
    }

    public function supprimer($idphase){
        $phaseJeu=PhaseJeu::find($idphase);
        $phaseJeu->effacerPhaseJeu();
        return redirect('PhaseJeu');
    }
}