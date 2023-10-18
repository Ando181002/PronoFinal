<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\DB;
use App\Models\TypeTournoi;
use App\Models\Tournoi;
use App\Models\Equipe;
use App\Models\Equipe_TypeTournoi;
use App\Models\TypeMatch;
use App\Models\Matchs;

class TournoiController extends Controller
{
    public function liste(){
        $typetournoi=TypeTournoi::all();
        $equipe=Equipe::all();
        $tournois=Tournoi::with('TypeTournoi')->get();
        return view('Admin.Tournoi',compact('typetournoi','equipe','tournois'));
    }

    public function ajouter(Request $req){
        $image = $req->file('image');
        $imageRedimensionnee = Image::make($image->getRealPath())->resize(298, 169);
        $base64_image = base64_encode($imageRedimensionnee->encode());
        $datepublication=now();
        $validation=Tournoi::reglesValidation('creation');
        $req->validate($validation['regles'],$validation['messages']);
        Tournoi::ajouterTournoi($req->input('nomtournoi'),$req->input('idtypetournoi'),$req->input('debuttournoi'),$req->input('fintournoi'),$req->input('description'),$req->input('frais'),$req->input('question'),$base64_image,$datepublication,$req->input('rang1'),$req->input('rang2'),$req->input('rang3'),$req->input('rang4'),$req->input('rang5'));
        return redirect('Tournoi');
    }

    public function modifier(Request $req,$idtournoi){
        $tournoi=Tournoi::find($idtournoi);
        if(!$tournoi){
            return redirect()->route('Tournoi')->with('error','Tournoi non trouvé.');
        }
        $validation=Tournoi::reglesValidation('modification');
        $req->validate($validation['regles'],$validation['messages']);
        $tournoi->modifierTypeTournoi($req->input('nomtournoi'),$req->input('idtypetournoi'),$req->input('debuttournoi'),$req->input('fintournoi'),$req->input('frais'),$req->input('question'),$req->input('descri'),$req->input('rang1'),$req->input('rang2'),$req->input('rang3'),$req->input('rang4'),$req->input('rang5'));
        return redirect('Tournoi');
    }

    public function supprimer($idtournoi){
        $tournoi=Tournoi::find($idtournoi);
        $tournoi->effacerTournoi();
        return redirect('Tournoi');
    }

    public function fiche($idtournoi){
        $typetournoi=TypeTournoi::all();
        $typematch=TypeMatch::all();
        $fichetournoi=Tournoi::find($idtournoi);
        $participant=$fichetournoi->inscriptions;
        $match=$fichetournoi->matchs;
        $resultats=[];
        foreach($match as $key){
            $resultat=DB::select('select* from resultatmatch where idmatch=?',[$key->idmatch]);
            $resultats[$key->idmatch] = $resultat;
        }
        $dateTournoi=DB::table('v_frais')->where('idtournoi','=',$idtournoi)->orderBy('date')->get();
        $classements=[];
        $idtypetournoi=$fichetournoi->idtypetournoi;
        $equipe=Equipe_TypeTournoi::with('Equipe')->where('idtypetournoi','=',$idtypetournoi)->get();
        return view('Admin.FicheTournoi',compact('participant','typetournoi','fichetournoi','typematch','equipe','match','classements','resultats','dateTournoi'));

    }

    
}