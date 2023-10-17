<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\TypeMatch;
use App\Models\PhaseJeu;

class TypeMatchController extends Controller
{
    public function liste(){
        $phase=PhaseJeu::all();
        $typematchs=TypeMatch::all();
        return view('Admin.TypeMatch',compact('typematchs','phase'));
    }

    public function ajouter(Request $req){
        $validation=TypeMatch::reglesValidation('creation');
        $req->validate($validation['regles'],$validation['messages']);
        TypeMatch::ajouterTypeMatch($req->input('nomtypematch'),$req->input('idphase'));
        return redirect('TypeMatch');
    }

    public function modifier(Request $req,$idtypematch){
        $typematch=TypeMatch::find($idtypematch);
        if(!$typematch){
            return redirect()->route('TypeMatch')->with('error','Type de match non trouvé.');
        }
        $validation=TypeMatch::reglesValidation('modification');
        $req->validate($validation['regles'],$validation['messages']);
        $typematch->modifierTypeMatch($req->input('nomtypematch'),$req->input('idphase'));
        return redirect('TypeMatch');
    }

    public function supprimer($idtypematch){
        $typematch=TypeMatch::find($idtypematch);
        $typematch->effacerTypeMatch();
        return redirect('TypeMatch');
    }
}