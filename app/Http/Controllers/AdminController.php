<?php

namespace App\Http\Controllers;
use Carbon\Carbon;
use PDF;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Admin;
use App\Models\TypeTournoi;
use App\Models\Equipe;
use App\Models\Equipe_TypeTournoi;
use App\Models\PeriodePronostic;
use App\Models\PhaseJeu;
use App\Models\TypeMatch;
use App\Models\Tournoi;
use App\Models\Matchs;
use App\Models\Inscription;
use App\Models\ResultatMatch;
use App\Models\Vainqueur;

class AdminController extends Controller
{
    public function loginAdmin(Request $req){
        $admin=Admin::where('email','=',$req['email'])->where('mdp','=',$req['mdp'])->get();
        if(count($admin)!=0){
            session(['idadmin'=> $admin[0]['idadmin']]); 
            $val=session()->get('idadmin');
            return view('Admin.AccueilAdmin');
        }
        else{
            $erreur="Email ou mot de passe éroné!";
            return view(
                'Admin.LoginAdmin',
                [
                    'erreur'  => $erreur,
                    'email' => $req['email']
                ]
            );
        }
    }
    public function logoutAdmin(){
        session()->flush();
        return redirect('/LoginAdmin');
    }
    public function Statistique(Request $req){
        $nbInscri_typetournoi=DB::table('v_nbinscription_typetournoi')->get();
        $typetournoi=TypeTournoi::all();
        $query = DB::table('v_nbinscription_departement')
            ->select('iddepartement', DB::raw('SUM(nbinscription) as nbinscription'))
            ->groupBy('iddepartement');
        if (isset($req['idtypetournoi'])) {
            $query->where('idtypetournoi', $req['idtypetournoi']);
        }   
        $nbInscri_departement = $query->get();
        return view('Admin.Statistique',compact('nbInscri_typetournoi','nbInscri_departement','typetournoi'));
    }
    

    //Match
    public function ajoutMatch(Request $req,$idtournoi){
        $duree=DB::select('Select dureeminute from tournoi t join typetournoi tt on t.idtypetournoi=tt.idtypetournoi where idtournoi=?',[$req['idtournoi']]);
        $dureematch=$duree[0]->dureeminute;
        $stringDateTime = $req['datematch']; // Votre chaîne de caractères représentant la date et l'heure
        $carbonDateTime = Carbon::parse($stringDateTime);
        $newCarbonDateTime = $carbonDateTime->addMinutes($dureematch);       
        $newDateTime = $newCarbonDateTime->format('Y-m-d\TH:i'); // Format de sortie : "2023-08-16T13:14"       
        $match = Matchs::create([
            'idtournoi' => $idtournoi,
            'idtypematch' => $req['idtypematch'],
            'datematch' => $req['datematch'],
            'finmatch' => $newDateTime,
            'idequipe1' => $req['idequipe1'],
            'idequipe2' => $req['idequipe2'],
            'ptresultat' => $req['ptresultat'],
            'ptscore' => $req['ptscore'],
            'stade' => $req['stade'],
            'avecresultat' => "0"
        ]);
        $url = url('FicheTournoi', ['idtournoi' => $idtournoi]);
        return redirect($url);
    }
    public function ajoutMatchCsv(Request $req,$idtournoi){
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
    public function updateMatch(Request $req,$idtournoi)
    {
        $duree=DB::select('Select dureeminute from tournoi t join typetournoi tt on t.idtypetournoi=tt.idtypetournoi where idtournoi=?',[$req['idtournoi']]);
        $dureematch=$duree[0]->dureeminute;
        $stringDateTime = $req['datematch']; // Votre chaîne de caractères représentant la date et l'heure
        $carbonDateTime = Carbon::parse($stringDateTime);
        $newCarbonDateTime = $carbonDateTime->addMinutes($dureematch);       
        $newDateTime = $newCarbonDateTime->format('Y-m-d\TH:i');
        $match = Matchs::find($req['idmatch']);
        $match->idtournoi = $idtournoi;
        $match->idtypematch = $req['idtypematch'];
        $match->datematch = $newDateTime;
        $match->finmatch = $req['datematch'];
        $match->idequipe1 = $req['idequipe1'];
        $match->idequipe2 = $req['idequipe2'];
        $match->ptresultat = $req['ptresultat'];
        $match->ptscore = $req['ptscore'];
        $match->update();
        $url = url('FicheTournoi', ['idtournoi' => $idtournoi]);
        return redirect($url); 
    }
    public function deleteMatch(){
        $typematch = TypeMatch::find($req['idtypematch']);
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
                Vainqueur::ajouterVainqueur($idtournoi,$vainqueur->trigramme,$vainqueur->montant);
            }
        }
        $url = url('FicheTournoi', ['idtournoi' => $idtournoi]);
        return redirect($url); 
    } 

    public function genererPdf() {
        $pdf = PDF::loadView('Admin.Pdf'); // 'pdf' est le nom de la vue créée
        return $pdf->stream('exemple.pdf'); // Stream le PDF ou utilisez ->download() pour le télécharger
    }
}