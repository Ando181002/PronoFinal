<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\TypeActivite;
use App\Models\Activite;

class ActiviteController extends Controller
{
    public function liste(){
        $typeActivites=TypeActivite::all();
        $activites=Activite::all();
        return view('Admin.Activite',compact('typeActivites','activites'));
    }

    public function ajouter(Request $req){
        $validation=Activite::reglesValidation('creation');
        $req->validate($validation['regles'],$validation['messages']);
        Activite::ajouterActivite($req->input('nomactivite'),$req->input('idtypeactivite'));
        return redirect('Activite');
    }

    public function modifier(Request $req,$idactivite){
        $activite=Activite::find($idactivite);
        if(!$activite){
            return redirect()->route('Activite')->with('error','Activité non trouvée.');
        }
        $validation=Activite::reglesValidation('modification');
        $req->validate($validation['regles'],$validation['messages']);
        $activite->modifierActivite($req->input('nomactivite'),$req->input('idtypeactivite'));
        return redirect('Activite');
    }

    public function supprimer($idactivite){
        $activite=Activite::find($idactivite);
        $activite->effacerActivite();
        return redirect('Activite');
    }
}