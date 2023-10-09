<?php
namespace App\Http\Controllers;
use Carbon\Carbon;
use App\Helpers\PasswordUtils;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Models\TypeTournoi;
use App\Models\Tournoi;
use App\Models\Compte;
use App\Models\Matchs;
use App\Models\Pronostic;

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
        $status="personnel";
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
        // Paramètres de connexion à Active Directory
        $serveurAD = "ldap.forumsys.com";
        $PortAD = 389; // Port par défaut pour LDAP non sécurisé
        $UtilisateurAD = "cn=read-only-admin,dc=example,dc=com";
        $MotDePasseAD = "password";
        $ldapConnection = ldap_connect($serveurAD, $PortAD);
        ldap_set_option($ldapConnection, LDAP_OPT_PROTOCOL_VERSION, 3); // Utilisation du protocole LDAP version 3
        ldap_bind($ldapConnection, $UtilisateurAD, $MotDePasseAD);
        $filtre = "(sAMAccountName=$trigramme)";
        $resultatRecherche = ldap_search($ldapConnection, "dc=example,dc=com", $filtre);
        if ($resultatRecherche) {
            $donnees = ldap_get_entries($ldapConnection, $resultatRecherche);
            if ($donnees["count"] > 0) {
                for ($i = 0; $i < $donnees["count"]; $i++) {
                    $mail = $donnees[$i]["mail"];
                    $mdp=PasswordUtils::generateTemporaryPassword();
                    $this->envoyerEmail($mdp,$mail);
                }
            }
        } else {
            echo "Erreur lors de la recherche dans l'annuaire AD.";
        }

        // Fermeture de la connexion LDAP
        ldap_close($ldapConnection);
    }
    public function Reinitialisation(){
        return view('Personnel.Reinitialisation');
    }
    public function Reinitialiser(){
        $url = url('login');
        return redirect($url);
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
        $Tournois=Tournoi::with('TypeTournoi')->get();
        $nonParticipe=DB::select('select t.*,nomtypetournoi from tournoi t join typetournoi tt on t.idtypetournoi=tt.idtypetournoi where idtournoi not in (select idtournoi from inscription where trigramme=?)', [$perso->trigramme]);
        $status="participant";
        return view('Personnel.Liste',compact('status','Tournois','nonParticipe'));       
    }    
    public function Statistique(){
        $status="participant";
        return view('Personnel.Statistique',compact('status'));       
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
            'numenvoyeur' => $perso->telephone,
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
                    'idtournoi' => $req['idtournoi'],
                    'idequipe1g' => $req['idequipe1g'],
                    'idequipe2g' => $req['idequipe2g'],
                    'reponsequestion' => $req['reponsequestion']
                ]);
                $url = url('Pronostiquer', ['idtournoi' => $idtournoi]);
                return redirect($url);
            }
            else{
                $erreur=$apiData['data'];
                $url = url('participerPronostic', ['idtournoi' => $idtournoi,'erreur' => $erreur]);
                return redirect($url);
            }
        } catch (Exception $e) {
            $erreur="Erreur de connexion. Veuillez réessayer plus tard";
            $url = url('participerPronostic', ['idtournoi' => $idtournoi,'erreur' => $erreur]);
            return redirect($url);
        }
    }
    public function Pronostiquer($idtournoi){
        $statut="participant";
        $perso=session()->get('perso');
        $participant=Inscription::where('idtournoi','=',$idtournoi)->where('trigramme','=',$perso->trigramme)->first();
        $idparticipant=$participant->idinscription;
        $tournoi =Tournoi::findOrFail($idtournoi);
        $matchs= DB::select('Select * from v_match where idtournoi=? and idparticipant=? order by datematch asc',[$idtournoi,$idparticipant]);
        $montantCagnote=Participant::where('idtournoi','=',$idtournoi)->get();
        $classements=[];
        foreach($matchs as $match){
            $classement=DB::select('select ROW_NUMBER() OVER (ORDER BY total DESC) AS numligne,c.*,trigramme from classement c join participant p on c.idparticipant=p.idparticipant where idmatch=? order by total desc limit 5',[$match->idmatch]);
            $classements[$match->idmatch] = $classement;
        }
        $Point=DB::table('v_point_partournoi')->where('idtournoi','=',$idtournoi)->where('idparticipant','=',$idparticipant)->first();
        $classementGlobal=DB::select('select ROW_NUMBER() OVER (ORDER BY finale DESC) AS numligne,trigramme,v.* from v_pointFinal v join participant p on v.idparticipant=p.idparticipant where v.idtournoi=? order by finale desc limit 5',[$idtournoi]);
        return view('Utilisateur.Pronostic', compact('Point','montantCagnote','idparticipant','tournoi','matchs','classements','classementGlobal','statut'));       
    }
    public function ajoutPronostic(Request $req,$idparticipant,$idtournoi){
        $statut="participant";
        $pronostic = Pronostic::create([
            'idmatch' => $req['idmatch'],
            'idparticipant' => $idparticipant,
            'prono1' => $req['prono1'],
            'prono2' => $req['prono2'],
            'datepronostic' => "now()",
        ]);
        $url = url('Pronostiquer', ['idtournoi' => $idtournoi]);
        return redirect($url);
    }
}