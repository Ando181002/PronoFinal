<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;
use App\Models\TypeTournoi;

class TypeTournoiController extends Controller
{
    public function liste(){
        $typetournois=TypeTournoi::all();
        return view('Admin.TypeTournoi',compact('typetournois'));
    }

    public function ajouter(Request $req){
        $image = $req->file('image');
        $imageRedimensionnee = Image::make($image->getRealPath())->resize(1920, 700);
        $base64_image = base64_encode($imageRedimensionnee->encode());
        $validation=TypeTournoi::reglesValidation('creation');
        $req->validate($validation['regles'],$validation['messages']);
        TypeTournoi::ajouterTypeTournoi($req->input('nomtypetournoi'),$req->input('dureeminute'),$req->input('dureeprolongation'),$base64_image);
        return redirect('TypeTournoi');
    }

    public function modifier(Request $req,$idtypetournoi){
        $typetournoi=TypeTournoi::find($idtypetournoi);
        if(!$typetournoi){
            return redirect()->route('TypeTournoi')->with('error','Type de tournoi non trouvé.');
        }
        $validation=TypeTournoi::reglesValidation('modification');
        $req->validate($validation['regles'],$validation['messages']);
        $typetournoi->modifierTypeTournoi($req->input('nomtypetournoi'),$req->input('dureeminute'),$req->input('dureeprolongation'));
        return redirect('TypeTournoi');
    }

    public function supprimer($idtypetournoi){
        $typetournoi=TypeTournoi::find($idtypetournoi);
        $typetournoi->effacerTypeTournoi();
        return redirect('TypeTournoi');
    }
}