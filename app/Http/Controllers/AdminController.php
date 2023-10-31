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

    public function genererPdf() {
        $vainqueurs=Vainqueur::where('idtournoi','=',4)->get();
        $pdf = PDF::loadView('Admin.Pdf',compact('vainqueurs')); // 'pdf' est le nom de la vue créée
        return $pdf->stream('exemple.pdf'); // Stream le PDF ou utilisez ->download() pour le télécharger
    }
    public function exportCsv(){
        $vainqueurs=Vainqueur::where('idtournoi','=',4)->get();
        $csvFileName = "exported_data.csv";
        // Créez une réponse avec le contenu du fichier CSV et les en-têtes appropriés
        $response = response()
            ->stream(
                function () use ($vainqueurs) {
                    $handle = fopen('php://output', 'w');
    
                    // Entête CSV
                    fputcsv($handle, ['Rang', 'Trigramme', 'Points','Montant']); // Remplacez par les en-têtes de votre CSV
    
                    // Lignes de données
                    foreach ($vainqueurs as $row) {
                        fputcsv($handle, [$row->rang, $row->trigramme, $row->points, $row->montant]); // Remplacez les champs par les données de votre modèle
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