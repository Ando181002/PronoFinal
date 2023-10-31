<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Mail;
use App\Mail\MonEmail;
use Illuminate\Http\Request;
use App\Models\Compte;
use App\Models\Personnel;

class CompteController extends Controller
{
    public function envoyerEmail($message,$email)
    {
        $name="ASOM";
        $subject="Renvoie de mot de passe temporaire";
        Mail::to($email)->send(new MonEmail($name,$email,$subject,$message));
    }
    public function CreerCompte(){
        return view('Personnel.CreerCompte');
    }
    public function TraitementInscription(Request $req){
        $trigramme=$req['trigramme'];
        $verifCompte=Compte::where('trigramme','=',$trigramme)->first();
        if($verifCompte){
            return redirect()->back()->withErrors('Ce trigramme est déjà associé à un compte.');
        }
        else{
            $verifAD=Personnel::where('trigramme','=',$trigramme)->first();
            if($verifAD){
                $mdp=PasswordUtils::generateTemporaryPassword();
                $compte = new Compte;
                $compte->trigramme= $trigramme;
                $compte->nom= $perso->nom;
                $compte->datenaissance= $perso->datenaissance;
                $compte->idgenre= $perso->idgenre;
                $compte->email= $perso->email;
                $compte->mdp= $mdp;
                $compte->telephone= $perso->telephone;
                $compte->idtypepersonnel= $perso->idtypepersonnel;
                $compte->iddepartement= $perso->iddepartement;
                $compte->save();
                //$this->envoyerEmail($mdp,$perso->email);
                $url = url('reinitialisationMdp',['trigramme' => $trigramme]);
                return redirect($url);
            }
            else{
                return redirect()->back()->withErrors('Ce trigramme n\'existe pas.');
            }
        }
    }
    
}