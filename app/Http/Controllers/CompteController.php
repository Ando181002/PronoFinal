<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Mail;
use App\Helpers\PasswordUtils;
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
                $dateActuelle = now();
                $dateActuelleCopie= clone $dateActuelle;
                $dateExpiration = $dateActuelleCopie->addMinutes(5);  
                $compte = new Compte;
                $compte->trigramme= $trigramme;
                $compte->nom= $verifAD->nom;
                $compte->datenaissance= $verifAD->datenaissance;
                $compte->idgenre= $verifAD->idgenre;
                $compte->email= $verifAD->email;
                $compte->mdp= $mdp;
                $compte->telephone= $verifAD->telephone;
                $compte->idtypepersonnel= $verifAD->idtypepersonnel;
                $compte->iddepartement= $verifAD->iddepartement;
                $compte->datecreation=$dateActuelle;
                $compte->dateexpiration=$dateExpiration;
                $compte->save();
                //$this->envoyerEmail($mdp,$compte->email);
                $url = url('reinitialisationMdp',['trigramme' => $trigramme]);
                return redirect($url);
            }
            else{
                return redirect()->back()->withErrors('Ce trigramme n\'existe pas.');
            }
        }
    }
    public function Reinitialisation($trigramme){
        return view('Personnel.Reinitialisation',compact('trigramme'));
    }
    public function Reinitialiser(Request $req){
        $compte = Compte::find($req['trigramme']);
        $dateActuelle=now();
        if($compte){
            if($compte->dateexpiration<$dateActuelle){
                $compte->delete();
                return redirect()->back()->withErrors('Mot de passe expiré. Veuillez redemander un nouveau.');
            }
            else{
                if($req['ancien']==$compte->mdp){
                    if($req['nouveau']==$req['confirmation']){
                        $compte->mdp=$req['nouveau'];
                        $compte->dateexpiration=null;
                        $compte->update();
                        $url = url('login');
                        return redirect($url);
                    }
                    else{
                        return redirect()->back()->withErrors('Mot de passe incorrect!');
                    }
                }
                else{
                    return redirect()->back()->withErrors('Mot de passe incorrect!');
                }
            }
        }
        else{

        }
    }
}