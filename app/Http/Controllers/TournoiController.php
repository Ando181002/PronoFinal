<?php

namespace App\Http\Controllers;
use PDF;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\DB;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Models\TypeTournoi;
use App\Models\Tournoi;
use App\Models\Equipe;
use App\Models\Equipe_TypeTournoi;
use App\Models\TypeMatch;
use App\Models\Matchs;
use App\Models\PhaseJeu;
use App\Models\ResultatMatch;
use App\Models\Vainqueur;
use App\Models\TypePersonnel;
use App\Models\Departement;
use App\Models\Inscription;

class TournoiController extends Controller
{
    public function liste(){
        $typetournoi=TypeTournoi::all();
        $equipe=Equipe::all();
        $tournois=Tournoi::with('TypeTournoi')->paginate(10);
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
        $tournoi->modifierTypeTournoi($req->input('nomtournoi'),$req->input('idtypetournoi'),$req->input('debuttournoi'),$req->input('fintournoi'),$req->input('descri'),$req->input('frais'),$req->input('question'),$req->input('rang1'),$req->input('rang2'),$req->input('rang3'),$req->input('rang4'),$req->input('rang5'));
        $url = url('FicheTournoi', ['idtournoi' => $idtournoi]);
        return redirect($url);  
    }

    public function supprimer($idtournoi){
        $tournoi=Tournoi::find($idtournoi);
        $tournoi->effacerTournoi();
        return redirect('Tournoi');
    }

    public function fiche(Request $req,$idtournoi){
        $typetournoi=TypeTournoi::all();
        $typematch=TypeMatch::all();
        $phasejeu=PhaseJeu::all();
        $typepersonnels=TypePersonnel::all();
        $departements=Departement::all();
        $fichetournoi=Tournoi::find($idtournoi);
        //$participant=$fichetournoi->inscriptions()->paginate(5);
        $participant=$fichetournoi->inscriptions();
        if ($req->input('nom')) {
            $participant->whereHas('compte',function($participant) use ($req){
                $participant->where('nom', 'ilike', '%' . $req->input('nom') . '%');
            });
        }
        if ($req->input('idtypepersonnel')) {
            $participant->whereHas('compte',function($participant) use ($req){
                $participant->where('idtypepersonnel', $req->input('idtypepersonnel') );
            });
        }
        if ($req->input('iddepartement')) {
            $participant->whereHas('compte',function($participant) use ($req){
                $participant->where('iddepartement', $req->input('iddepartement') );
            });
        }
        $participant = $participant->paginate(5);
        $match=$fichetournoi->matchs()->with('pronostics','resultat')->paginate(2);
        $dateTournoi=DB::table('v_frais')->where('idtournoi','=',$idtournoi)->orderBy('date')->get();
        $idtypetournoi=$fichetournoi->idtypetournoi;
        $equipe=Equipe_TypeTournoi::with('Equipe')->where('idtypetournoi','=',$idtypetournoi)->get();
        $idphase=0;
        if($req->input('idphase')){
            $idphase=$req->input('idphase');
        }
        $classements=$fichetournoi->inscriptions;
        $classements=$classements->sortByDesc(function($classement) use ($idphase){
            return $classement->pointParPhase($idphase);
        });
        return view('Admin.FicheTournoi',compact('phasejeu','participant','typetournoi','fichetournoi','typematch','equipe','match','dateTournoi','typepersonnels','departements','classements','idphase'));
    }

    public function ajouterMatch(Request $req,$idtournoi){
        $tournoi=Tournoi::find($idtournoi);
        if($req->input('datematch')<$tournoi->debuttournoi || $req->input('datematch')>$tournoi->fintournoi){
            return redirect()->back()->withErrors('La date du match est hors tournoi.');
        }
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
            while(($data=fgetcsv($handle, 0, ';')) !==false) {
                $values=$data;
                $typematch=TypeMatch::Where('nomtypematch',$values[0])->first();
                $equipe1=Equipe::Where('nomequipe',$values[3])->first(); 
                $equipe2=Equipe::Where('nomequipe',$values[4])->first(); 
                $tournoi=Tournoi::find($idtournoi);
                $datematch= \Carbon\Carbon::createFromFormat('d/m/Y H:i',$values[1]);
                $ptresultat=$values[5];
                $ptscore=$values[6];
                if($datematch<$tournoi->debuttournoi || $datematch>$tournoi->fintournoi){
                    $message="La date du match est hors tournoi. Debut: ".$tournoi->debuttournoi." Datematch:".$datematch." Fin:".$tournoi->fintournoi;
                    return redirect()->back()->withErrors($message);
                }
                //$validation=Matchs::reglesValidation('creation');
                //$req->validate($validation['regles'],$validation['messages']);
                dd(Matchs::ajouterMatch($idtournoi,$typematch->idtypematch,$datematch,$req->input('finmatch'),$equipe1->idequipe,$equipe2->idequipe,$values[2],$ptresultat,$ptscore,0));      
            }
            fclose($handle);
            return redirect()->back()->with('succes','Enregistrer');
        }
        else{
            return redirect()->back()->withErrors('Erreur d enregistrement');  
        }
    }

    /*public function ajouterMatchCsv(Request $req,$idtournoi){
        if ($req->hasFile('csv')) {
            $file=$req->file('csv');
            $handle=fopen($file->getPathname(), 'r');
            $table_data=array();
            while(($data=fgetcsv($handle, 0, ';')) !==false) {
                $values=$data;
                $typematch=TypeMatch::Where('nomtypematch',$values[0])->first();
                $datematch=isset($values[1]) ? $values[1] : null; 
                $tournoi=Tournoi::find($idtournoi);
                if($datematch<$tournoi->debuttournoi || $datematch>$tournoi->fintournoi){
                    return redirect()->back()->withErrors('La date du match est hors tournoi.');
                }
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
        else{ 
            return redirect()->back()->withErrors('Erreur d enregistrement');  
        }   
    }*/

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
    public function genererPdf($idtournoi,$idphase) {
        $tournoi=Tournoi::find($idtournoi);
        $classements=$tournoi->inscriptions;
        $classements=$classements->sortByDesc(function($classement) use ($idphase){
            return $classement->pointParPhase($idphase);
        });
        $pdf = PDF::loadView('Admin.Pdf',compact('classements','idphase')); // 'pdf' est le nom de la vue créée
        return $pdf->stream('exemple.pdf'); // Stream le PDF ou utilisez ->download() pour le télécharger
    }
    public function exportCsv($idtournoi,$idphase){
        $tournoi=Tournoi::find($idtournoi);
        $classements=$tournoi->inscriptions;
        $classements=$classements->sortByDesc(function($classement) use ($idphase){
            return $classement->pointParPhase($idphase);
        });   
        $csvFileName = "exported_data.csv";
        // Créez une réponse avec le contenu du fichier CSV et les en-têtes appropriés
        $response = response()
            ->stream(
                function () use ($classements,$idphase) {
                    $handle = fopen('php://output', 'w');
    
                    // Entête CSV
                    fputcsv($handle, ['Position', 'Participant', 'Score']); // Remplacez par les en-têtes de votre CSV
                    $rang=1;
                    // Lignes de données                 
                    foreach ($classements as $row) {
                        fputcsv($handle, [$rang, $row->trigramme, $row->pointParPhase($idphase)]);
                        $rang++;
                    }
    
                    fclose($handle);
                },
                200,
                [
                    'Content-Type' => 'text/csv',
                    'Content-Disposition' => "attachment; filename=$csvFileName",
                ]
            );
    
        return $response;
    }
    
}