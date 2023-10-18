<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;
use App\Models\Lieu;

class LieuController extends Controller
{
    public function liste(){
        $lieux=Lieu::all();
        return view('Admin.Lieu',compact('lieux'));
    }

    public function ajouter(Request $req){
        $image = $req->file('image');
        $imageRedimensionnee = Image::make($image->getRealPath())->resize(100, 100);
        $base64_image = base64_encode($imageRedimensionnee->encode());
        $validation=Lieu::reglesValidation('creation');
        $req->validate($validation['regles'],$validation['messages']);
        Lieu::ajouterLieu($req->input('nomlieu'),$base64_image,$req->input('latitude'),$req->input('longitude'));
        return redirect('Lieu');
    }

    public function modifier(Request $req,$idlieu){
        $image = $req->file('image');
        $imageRedimensionnee = Image::make($image->getRealPath())->resize(100, 100);
        $base64_image = base64_encode($imageRedimensionnee->encode());
        $lieu=Lieu::find($idlieu);
        if(!$lieu){
            return redirect()->route('Lieu')->with('error','Lieu non trouvé.');
        }
        $validation=Lieu::reglesValidation('modification');
        $req->validate($validation['regles'],$validation['messages']);
        $Lieu->modifierLieu($req->input('nomlieu'),$base64_image,$req->input('latitude'),$req->input('longitude'));
        return redirect('Lieu');
    }

    public function supprimer($idlieu){
        $lieu=Lieu::find($idlieu);
        $lieu->effacerLieu();
        return redirect('Lieu');
    }
}