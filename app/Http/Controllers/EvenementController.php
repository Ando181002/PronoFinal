<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Evenement;
use App\Models\Lieu;
use App\Models\Activite;
use App\Models\Genre;

class EvenementController extends Controller
{
    public function liste(){
        $evenements=Evenement::with('Lieu')->get();
        $lieux=Lieu::all();
        return view('Admin.Evenement',compact('evenements','lieux'));
    }

    public function ajouter(Request $req){
        $validation=Evenement::reglesValidation('creation');
        $req->validate($validation['regles'],$validation['messages']);
        Evenement::ajouterEvenement($req->input('nomevenement'),$req->input('dateevenement'),$req->input('fininscription'),$req->input('idlieu'));
        return redirect('Evenement');
    }

    public function modifier(Request $req,$idevenement){
        $evenement=Evenement::find($idevenement);
        if(!$evenement){
            return redirect()->route('Evenement')->with('error','Evènement non trouvé.');
        }
        $validation=Evenement::reglesValidation('modification');
        $req->validate($validation['regles'],$validation['messages']);
        $evenement->modifierEvenement($req->input('nomevenement'),$req->input('dateevenement'),$req->input('fininscription'),$req->input('idlieu'));
        $url = url('ficheEvenement', ['idevenement' => $idevenement]);
        return redirect($url);
    }

    public function fiche($idevenement){
        $evenement=Evenement::find($idevenement);
        $lieux=Lieu::all();
        $genres=Genre::all();
        $listeActivite=Activite::with('TypeActivite')->get();
        $activites=$evenement->activites;
        return view('Admin.ficheEvenement',compact('evenement','lieux','activites','listeActivite','genres'));    
        return redirect('Evenement');   
    }

    public function ajouterActivite($idevenement,Request $req){
        $evenement=Evenement::find($idevenement);
        $evenement->ajouterActivite($req->input('idactivite'),$req->input('dureeactivite'),$req->input('nombrejoueur'),$req->input('idgenre'));
        $url = url('ficheEvenement', ['idevenement' => $idevenement]);
        return redirect($url);
    }

    public function modifierActivite(Request $req,$idevenement,$idevenement_activite){
       $evenement = Evenement::findOrFail($idevenement);
        // Appelez la méthode modifierActivite sur l'instance de l'événement
        $evenement->modifierActivite($idevenement_activite,$req->input('dureeactivite'),$req->input('nombrejoueur'),$req->input('idgenre'));
        $url = url('ficheEvenement', ['idevenement' => $idevenement]);
        return redirect($url);
    }
  
    public function effacerActivite($idevenement,$idevenement_activite){
        $evenement = Evenement::findOrFail($idevenement);
        $evenement->supprimerActivite($idevenement_activite);
        $url = url('ficheEvenement', ['idevenement' => $idevenement]);
        return redirect($url);
    }

    public function listeEvenement(){
        $status="personnel";
        $evenements=Evenement::with('Lieu')->get();
        return view('Evenement.listeEvenement',compact('status','evenements'));        
    }
    public function detailEvenement($idevenement){
        $status="personnel";
        $evenement=Evenement::with('Lieu')->find($idevenement);
        $activites=$evenement->activites;
        return view('Evenement.ficheEvenement',compact('status','evenement','activites'));        
    }
    public function detailActivite(){
        $status="personnel";
        return view('Evenement.detailActivite',compact('status'));       
    }
}