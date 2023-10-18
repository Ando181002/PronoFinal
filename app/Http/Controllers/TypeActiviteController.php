<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\TypeActivite;

class TypeActiviteController extends Controller
{
    public function liste(){
        $typeActivites=TypeActivite::all();
        return view('Admin.TypeActivite',compact('typeActivites'));
    }

    public function ajouter(Request $req){
        $validation=TypeActivite::reglesValidation('creation');
        $req->validate($validation['regles'],$validation['messages']);
        TypeActivite::ajouterTypeActivite($req->input('nomtypeactivite'));
        return redirect('TypeActivite');
    }

    public function modifier(Request $req,$idtypeactivite){
        $typeactivite=TypeActivite::find($idtypeactivite);
        if(!$typeactivite){
            return redirect()->route('TypeActivite')->with('error','Type d\'activité non trouvé.');
        }
        $validation=TypeActivite::reglesValidation('modification');
        $req->validate($validation['regles'],$validation['messages']);
        $typeactivite->modifierTypeActivite($req->input('nomtypeactivite'));
        return redirect('TypeActivite');
    }

    public function supprimer($idtypeactivite){
        $typeactivite=TypeActivite::find($idtypeactivite);
        $typeactivite->effacerTypeActivite();
        return redirect('TypeActivite');
    }
}