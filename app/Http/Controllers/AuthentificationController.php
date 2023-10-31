<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Admin;
use App\Models\Compte;

class AuthentificationController extends Controller
{
    public function Login(){
        return view('Accueil.Login');
    }
    public function TraitementLogin(Request $req){
        $identifiant=$req->input('identifiant');
        $mdp=$req->input('mdp');
        $utilisateur="Admin";
        $utilisateur=Admin::where('email','=',$identifiant)->where('mdp','=',$mdp)->first();
        $url="Tournoi";
        if(strlen($identifiant)==3){
            $utilisateur=Compte::where('trigramme','=',$identifiant)->where('mdp','=',$mdp)->first();
            $url="liste";
        }
        if($utilisateur){
            session(['utilisateur'=> $utilisateur]); 
            return redirect($url);
        }
        else{
            return redirect()->back()->withErrors('Identifiant ou mot de passe erroné.');
        }
    }
    public function logoutAdmin(){
        session()->flush();
        return redirect('/LoginAdmin');
    }
}