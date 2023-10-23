<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\PeriodePronostic;

class PeriodePronosticController extends Controller
{
     //Periode pronostic
     public function liste(){
        $periode=PeriodePronostic::orderBy('numjour')->get();
        return view('Admin.PeriodePronostic',compact('periode')); 
    }
    public function ajouter(Request $req){
        $validation=PeriodePronostic::reglesValidation('creation');
        $req->validate($validation['regles'],$validation['messages']);
        PeriodePronostic::ajouterPeriode($req->input('numjour'),$req->input('nomjour'),$req->input('limite'));
        $url = url('PeriodePronostic');
        return redirect($url);
    }
    public function modifier(Request $req,$idperiode)
    {
        $periodepronostic=PeriodePronostic::find($idperiode);
        if(!$periodepronostic){
            return redirect()->route('PeriodePronostic')->with('error','Période de pronostic non trouvée.');
        }
        $validation=PeriodePronostic::reglesValidation('modification');
        $req->validate($validation['regles'],$validation['messages']);
        $typetournoi->modifierPeriode($req->input('numjour'),$req->input('nomjour'),$req->input('limite'));
        $url = url('PeriodePronostic');
        return redirect($url);    
    }


}