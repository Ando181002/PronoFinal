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
use App\Models\PhaseJeu;
use App\Models\ResultatMatch;
use App\Models\Vainqueur;

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
        $phasejeu=PhaseJeu::all();
        $fichetournoi=Tournoi::find($idtournoi);
        $participant=$fichetournoi->inscriptions;
        $match=$fichetournoi->matchs->load(['pronostics','resultat']);
        $dateTournoi=DB::table('v_frais')->where('idtournoi','=',$idtournoi)->orderBy('date')->get();
        $classements=[];
        $idtypetournoi=$fichetournoi->idtypetournoi;
        $equipe=Equipe_TypeTournoi::with('Equipe')->where('idtypetournoi','=',$idtypetournoi)->get();
        return view('Admin.FicheTournoi',compact('phasejeu','participant','typetournoi','fichetournoi','typematch','equipe','match','classements','dateTournoi'));
    }

    public function ajouterMatch(Request $req,$idtournoi){
        $validation=Matchs::reglesValidation('creation');
        $req->validate($validation['regles'],$validation['messages']);
        Matchs::ajouterMatch($idtournoi,$req->input('idtypematch'),$req->input('datematch'),$req->input('finmatch'),$req->input('idequipe1'),$req->input('idequipe2'),$req->input('stade'),$req->input('ptresultat'),$req->input('ptscore'),0);
        $url = url('FicheTournoi', ['idtournoi' => $idtournoi]);
        return redirect($url);       
    }

    public function ajouterMatchCsv(Request $req,$idtournoi){
        if ($req->hasFile('csv')) {
            $file=$req->file('csv');
            $handle=fopen($file->getPathname(), 'r');
            $table_data=array();
            while(($data=fgetcsv($handle, 0, ';')) !==false) {
                $values=$data;
                $typematch=TypeMatch::Where('nomtypematch',$values[0])->first();
                $datematch=Carbon::createFromFormat('d/m/Y H:i',$values[1])->format('Y-m-d H:i'); 
                $duree=DB::select('Select dureeminute from tournoi t join typetournoi tt on t.idtypetournoi=tt.idtypetournoi where idtournoi=?',[$idtournoi]);
                $dureematch=$duree[0]->dureeminute;
                $datee = Carbon::parse($datematch);
                $finmatch = $datee->addMinutes($dureematch);       
                $finmatch = $finmatch->format('Y-m-d H:i');  
                $equipe1=Equipe::Where('nomequipe',$values[3])->first(); 
                $equipe2=Equipe::Where('nomequipe',$values[4])->first();            
                $table_data[]=[
                    'idtypematch'=> $typematch->idtypematch,
                    'idtournoi'=>$idtournoi,
                    'datematch'=>$datematch,
                    'finmatch'=>$finmatch,
                    'stade'=>$values[2],
                    'idequipe1'=>$equipe1->idequipe,
                    'idequipe2'=>$equipe2->idequipe,
                    'ptresultat'=>$values[5],
                    'ptscore'=>$values[6],
                    'avecresultat'=>"0"
                ];
            }
            fclose($handle);
            DB::table('matchs')->insert($table_data);
            return redirect()->back()->with('succes','Enregistrer');
        }
        else return redirect()->back()->with('succes','Erreur d enregistrement');      
    }

    public function modifierMatch(Request $req,$idtournoi,$idmatch)
    {
        $match=Matchs::find($idmatch);
        if(!$match){
            return redirect()->back()->with('error','Match non trouvé.');
        }
        $validation=Matchs::reglesValidation('modification');
        $req->validate($validation['regles'],$validation['messages']);
        $match->modifierMatch($idtournoi,$req->input('idtypematch'),$req->input('datematch'),$req->input('finmatch'),$req->input('idequipe1'),$req->input('idequipe2'),$req->input('stade'),$req->input('ptresultat'),$req->input('ptscore'));
        $url = url('FicheTournoi', ['idtournoi' => $idtournoi]);
        return redirect($url); 
    }
    public function supprimerMatch($idtournoi,$idmatch){
        $match=Matchs::find($idmatch);
        $match->effacerMatch();
        $url = url('FicheTournoi', ['idtournoi' => $idtournoi]);
        return redirect($url); 
    }
    public function ajoutResultatMatch(Request $req,$idtournoi){        
        $validation=ResultatMatch::reglesValidation('creation');
        $dateresultat=now();
        $req->validate($validation['regles'],$validation['messages']);
        ResultatMatch::ajouterResultatMatch($req->input('idmatch'),$dateresultat,$req->input('score1'),$req->input('score2'));
        $match = Matchs::find($req->input('idmatch'));
        $match->avecresultat="1";
        $match->update();
        $estfinal=$match->estFinal();
        if($estfinal){
            $tournoi=Tournoi::find($idtournoi);
            $vainqueurs=$tournoi->vainqueurs();
            foreach($vainqueurs as $vainqueur){
                Vainqueur::ajouterVainqueur($idtournoi,$vainqueur->trigramme,$vainqueur->montant,$vainqueur->pointfinal(),$vainqueur->rang);
            }
        }
        $url = url('FicheTournoi', ['idtournoi' => $idtournoi]);
        return redirect($url); 
    } 
    
}