<?php
namespace App\Http\Controllers;
use Carbon\Carbon;
use App\Helpers\PasswordUtils;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use GuzzleHttp\Client;
//use Illuminate\Support\Facades\Mail;
//use App\Mail\MonEmail;
use App\Models\TypeTournoi;
use App\Models\Tournoi;
use App\Models\Compte;
use App\Models\Matchs;
use App\Models\Pronostic;
use App\Models\Personnel;
use App\Models\Inscription;
use App\Models\Vainqueur;
use App\Models\PhaseJeu;

class PersonnelController extends Controller
{
    public function Accueil(){
        $typetournoi=TypeTournoi::all();
        $Tournois=Tournoi::with('TypeTournoi')->get();
        $tournoisParType=[];
        foreach($typetournoi as $type){
            $tournoi=Tournoi::with('TypeTournoi')->where('idtypetournoi','=',$type->idtypetournoi)->get();
            $tournoisParType[$type->idtypetournoi] = $tournoi;
        }
        $status="personnel";
        return view('Personnel.Accueil',compact('status','typetournoi','Tournois','tournoisParType'));
    }
    public function DetailTournoi(Request $req){
        if(isset($req['status'])){
            $status=$req['status'];
        }
        else{
            $status="personnel";
        }
        $tournoi = Tournoi::findOrFail($req['id']);
        $matchs=Matchs::with('typeMatch')->with('Equipe1')->with('Equipe2')->where('idtournoi','=',$req['id'])->get();
        return view('Personnel.DetailTournoi', compact('tournoi','matchs','status'));
    }
    public function CreerCompte(){
        return view('Personnel.CreerCompte');
    }
    public function envoyerEmail($message,$email)
    {
        $name="ASOM";
        $email="rakotoarisoatendry13@gmail.com";
        $subject="Renvoie de mot de passe temporaire";
        Mail::to($email)->send(new MonEmail($name,$email,$subject,$message));
    }
    public function TraitementInscription(Request $req){
        $trigramme=$req['trigramme'];
        $perso=Personnel::where('trigramme','=',$req['trigramme'])->first();
        if(isset($perso)){
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

            $url = url('reinitialisationMdp',['trigramme' => $trigramme]);
            return redirect($url);
        }
        else{
            $erreur="Utilisateur non trouvé!";
            return view(
                'Personnel.CreerCompte',
                [
                    'erreur'  => $erreur,
                    'trigramme' => $req['trigramme']
                ]
            );            
        }

    }
    public function Reinitialisation($trigramme){
        return view('Personnel.Reinitialisation',compact('trigramme'));
    }
    public function Reinitialiser(Request $req){
        $compte = Compte::find($req['trigramme']);
        if($req['ancien']==$compte->mdp){
            if($req['nouveau']==$req['confirmation']){
                $compte->mdp=$req['nouveau'];
                $compte->update();
                $url = url('login');
                return redirect($url);
            }
            else{
                $erreur="Vérifiez le mot de passe";
                return view(
                    'Personnel.Reinitialisation',
                    [
                        'erreur'  => $erreur,
                        'trigramme' => $req['trigramme']
                    ]
                );
            }
        }
        else{
            $erreur="Vérifiez le mot de passe";
            return view(
                'Personnel.Reinitialisation',
                [
                    'erreur'  => $erreur,
                    'trigramme' => $req['trigramme']
                ]
            );
        }
    }
    public function Login(){
        return view('Personnel.Login');
    }
    public function TraitementLogin(Request $req){
        $perso=Compte::where('trigramme','=',$req['trigramme'])->where('mdp','=',$req['mdp'])->first();
        if(isset($perso)){
            session(['perso'=> $perso]);
            $tournois=Tournoi::with('TypeTournoi')->get();
            $status="participant";
            $url = url('liste');
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
    public function Deconnexion(){
        session()->flush();
        return redirect('/');       
    }
    public function Liste(){
        $perso=session()->get('perso');
        $compte=Compte::find($perso->trigramme);
        $nonParticipe=$compte->tournoiNonParticipe();
        $encours=$compte->tournoiEnCours();
        $gagnes=$compte->tournoiGagne();
        $perdus=$compte->tournoiPerdu();
        $status="participant";
        return view('Personnel.Liste',compact('status','nonParticipe','encours','gagnes','perdus'));       
    }    
    public function Statistique(){
        $perso=session()->get('perso');
        $mise = DB::table('inscription')
            ->join('tournoi', 'inscription.idtournoi', '=', 'tournoi.idtournoi')
            ->where('trigramme', $perso->trigramme)
            ->groupBy('trigramme')
            ->sum('frais');       
        $status="participant";
        $compte=Compte::find($perso->trigramme);
        $gagne=$compte->montantGagne();
        return view('Personnel.Statistique',compact('status','mise','gagne','compte'));       
    }
    public function formulaireParticipation($idtournoi,$erreur){
        $perso=session()->get('perso');
        $status="participant";
        $tournoi=Tournoi::find($idtournoi);
        $equipes = DB::select('Select * from v_equipe_parTournoi');
        return view('Personnel.Paiement',compact('status','tournoi','equipes','erreur','perso'));  
    }
    public function Participer(Request $req){
        $idtournoi=$req['idtournoi'];
        $tournoi=Tournoi::find($idtournoi);
        $perso=session()->get('perso');
        $descri="Tournoi".$idtournoi."-".$perso->trigramme;
          // Créez une instance de client Guzzle
        $client = new Client();

          // URL de l'API CodeIgniter pour la méthode "transfert"
        $apiUrl = 'http://127.0.0.1/OrangeMoney/api/transfert';
  
          // Données à envoyer à l'API pour la méthode "transfert"
        $data = [
            'numenvoyeur' => $req['numero'],
            'numrecepteur' => '0321453421',
            'montant' => $tournoi->frais,
            'objet' => $descri,
            'codesecret' => $req['codesecret'],
        ];
  
        try {
            // Effectuez une requête POST vers l'API CodeIgniter pour la méthode "transfert"
            $response = $client->request('POST', $apiUrl, [
                'form_params' => $data,
            ]);
            // Obtenez le contenu de la réponse (au format JSON)
            $apiData = json_decode($response->getBody(), true);
            if($apiData['status']=="success"){
                $participant = Inscription::create([
                    'trigramme' => $perso->trigramme,
                    'dateinscription' => now(),
                    'idtournoi' => $req['idtournoi'],
                    'idequipe1g' => $req['idequipe1g'],
                    'idequipe2g' => $req['idequipe2g'],
                    'reponsequestion' => $req['reponsequestion']
                ]);
                $url = url('Pronostiquer', ['idtournoi' => $idtournoi]);
                return redirect($url);
            }
            else{
                $erreur = $apiData['data'];
                session()->flash('erreur', $erreur); // Stockez le message d'erreur dans la variable de session flash
                return redirect()->back();
            }
        } catch (Exception $e) {
            $erreur="Erreur de connexion. Veuillez réessayer plus tard";
            session()->flash('erreur', $erreur); // Stockez le message d'erreur dans la variable de session flash
            return redirect()->back();
        }
    }

  /*  public function Pronostiquer($idtournoi){
        $status="participant";
        $perso=session()->get('perso');
        $inscription=Inscription::where('idtournoi','=',$idtournoi)->where('trigramme','=',$perso->trigramme)->first();
        $idinscription=$inscription->idinscription;
        $tournoi =Tournoi::findOrFail($idtournoi);
        $matchs= DB::select('Select * from v_match where idtournoi=? and idinscription=? order by datematch asc',[$idtournoi,$idinscription]);
        $montantCagnote=Inscription::where('idtournoi','=',$idtournoi)->get();
        $classements=[];
        foreach($matchs as $match){
            $classement=DB::select('select ROW_NUMBER() OVER (ORDER BY total DESC) AS numligne,c.*,trigramme from classement c join inscription p on c.idinscription=p.idinscription where idmatch=? order by total desc limit 5',[$match->idmatch]);
            $classements[$match->idmatch] = $classement;
        }
        $Point=DB::table('v_point_partournoi')->where('idtournoi','=',$idtournoi)->where('idinscription','=',$idinscription)->first();
        $classementGlobal=$tournoi->vainqueurs();
        return view('Personnel.Pronostic', compact('Point','montantCagnote','idinscription','tournoi','matchs','classements','classementGlobal','status'));       
    }*/
    public function Pronostiquer($idtournoi){
        $status="participant";
        $perso=session()->get('perso'); 
        $inscription=Inscription::where('idtournoi','=',$idtournoi)->where('trigramme','=',$perso->trigramme)->first(); 
        $tournoi =Tournoi::findOrFail($idtournoi);
        $matchs=$tournoi->matchs;
        $phasejeu=PhaseJeu::all();
        return view('Personnel.Pronostic2',compact('status','tournoi','matchs','inscription','phasejeu'));  
    }
    public function ajoutPronostic(Request $req,$idinscription,$idtournoi){
        $validation=Pronostic::reglesValidation('creation');
        $datepronostic=now();
        $req->validate($validation['regles'],$validation['messages']);
        Pronostic::ajouterPronostic($req->input('idmatch'),$idinscription,$req->input('prono1'),$req->input('prono2'),$datepronostic);
        $url = url('Pronostiquer', ['idtournoi' => $idtournoi]);
        return redirect($url);
    }
}