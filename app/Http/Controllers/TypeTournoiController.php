<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\TypeTournoi;

class TypeTournoiController extends Controller
{
    public function liste(){
        $typetournois=TypeTournoi::all();
        return view('Admin.TypeTournoi',compact('typetournois'));
    }

    public function ajouter(Request $req){
        $validation=TypeTournoi::reglesValidation('creation');
        $req->validate($validation['regles'],$validation['messages']);
        TypeTournoi::ajouterTypeTournoi($req->input('nomtypetournoi'));
        return redirect('TypeTournoi');
    }

    public function modifier(Request $req,$idtypetournoi){
        $typetournoi=TypeTournoi::find($idtypetournoi);
        if(!$typetournoi){
            return redirect()->route('TypeTournoi')->with('error','Type de tournoi non trouvé.');
        }
        $validation=TypeTournoi::reglesValidation('modification');
        $req->validate($validation['regles'],$validation['messages']);
        $typetournoi->modifierTypeTournoi($req->input('nomtypetournoi'));
        return redirect('TypeTournoi');
    }

    public function supprimer($idtypetournoi){
        $typetournoi=TypeTournoi::find($idtypetournoi);
        $typetournoi->effacerTypeTournoi();
        return redirect('TypeTournoi');
    }
}