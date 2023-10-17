<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;

class EvenementController extends Controller
{
    public function liste(){
        $status="personnel";
        return view('Evenement.listeEvenement',compact('status'));
    }

    public function fiche(){
        $status="personnel";
        return view('Evenement.ficheEvenement',compact('status'));       
    }
  
    public function detailActivite(){
        $status="personnel";
        return view('Evenement.detailActivite',compact('status'));       
    }
}