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

    public function modifierActivite($idevenement,$idactivite,Request $req){
        $evenement = Evenement::findOrFail($idEvenement);
        // Appelez la méthode modifierActivite sur l'instance de l'événement
        $evenement->modifierActivite(
            $idactivite,
            $request->input('dureeactivite'),
            $request->input('nombrejoueur'),
            $request->input('idgenre')
        );        $url = url('ficheEvenement', ['idevenement' => $idevenement]);
        return redirect($url);
    }
  
    public function detailActivite(){
        $status="personnel";
        return view('Evenement.detailActivite',compact('status'));       
    }
}