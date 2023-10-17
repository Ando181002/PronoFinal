<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\DB;
use App\Models\Equipe;
use App\Models\TypeTournoi;
use App\Models\Equipe_TypeTournoi;

class EquipeController extends Controller
{
    public function liste(){
        $typetournois=TypeTournoi::all();
        $equipes=Equipe::all();
        return view('Admin.Equipe',compact('equipes','typetournois'));
    }

    public function ajouter(Request $req){
        $image = $req->file('image');
        $imageRedimensionnee = Image::make($image->getRealPath())->resize(50, 30);
        $base64_image = base64_encode($imageRedimensionnee->encode());
        $validation=Equipe::reglesValidation('creation');
        $req->validate($validation['regles'],$validation['messages']);
        Equipe::ajouterEquipe($req->input('nomequipe'),$base64_image);
        $getEquipe=DB::select('select * from Equipe order by idequipe desc limit 1');
        $idEquipe=$getEquipe[0]->idequipe;
        $idtypetournoiSelectionnés = $req->input('idtypetournoi', []);
        if (is_array($idtypetournoiSelectionnés) && count($idtypetournoiSelectionnés) > 0) {
            foreach ($idtypetournoiSelectionnés as $idtypetournoi) {
                $equipeTypeTournoi = Equipe_TypeTournoi::create([
                    'idequipe' => $idEquipe,
                    'idtypetournoi' => $idtypetournoi,
                ]);
            }
        }
        return redirect('Equipe');
    }

    public function modifier(Request $req,$idequipe){
        $equipe=Equipe::find($idequipe);
        if(!$equipe){
            return redirect()->route('Equipe')->with('error','Equipe non trouvée.');
        }
        $validation=Equipe::reglesValidation('modification');
        $req->validate($validation['regles'],$validation['messages']);
        $equipe->modifierEquipe($req->input('nomequipe'));
        return redirect('Equipe');
    }

    public function supprimer($idequipe){
        $equipe=Equipe::find($idequipe);
        $equipe->effacerEquipe();
        return redirect('Equipe');
    }
}