<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Admin;
use App\Models\Compte;

class AuthentificationController extends Controller
{
   public function login(Request $req){
        $identifiant=$req->input('identifiant');
        $mdp=$req->input('mdp');
        $utilisateur=Admin::where('email','=',$identifiant)->where('mdp','=',$mdp)->first();
        $url="Tournoi";
        if(strlen($identifiant)==3){
            $utilisateur=Compte::where('trigramme','=',$req['trigramme'])->where('mdp','=',$mdp)->first();
            $url="liste";
        }
        if($utilisateur){
            session(['utilisateur'=> $utlisateur]); 
            return redirect($url);
        }
        else{
            $erreur="Email ou mot de passe éroné!";
            return view(
                'Personnel.Login',
                [
                    'erreur'  => $erreur,
                    'trigramme' => $req['trigramme']
                ]
            );
        }
   }
}