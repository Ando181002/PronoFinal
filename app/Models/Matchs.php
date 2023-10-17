<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Matchs extends Model
{
    use HasFactory;

    public $timestamps=false;
    protected $table = 'matchs';
    protected $primaryKey='idmatch';
    protected $fillable = ['idtypematch','idtournoi','datematch','finmatch','stade','idequipe1','idequipe2','ptresultat','ptscore','avecresultat'];

    public function TypeMatch()
    {
        return $this->belongsTo(TypeMatch::class, 'idtypematch');
    }
    public function Tournoi()
    {
        return $this->belongsTo(Tournoi::class, 'idtournoi');
    }
    public function Equipe1()
    {
        return $this->belongsTo(Equipe::class, 'idequipe1');
    }
    public function Equipe2()
    {
        return $this->belongsTo(Equipe::class, 'idequipe2');
    }
     //On gère les règles de validation  des attributs
     public static function reglesValidation($contexte){
        $regles = [
            'ptresultat' => 'required|int',
            'ptscore' => 'required|int',
        ];
        $messages = [
            'ptresultat.required' => 'Le point pour le resultat est requis.',
            'ptresultat.int' => 'Le point pour le resultat doit être un nombre.',
            'ptscore.required' => 'Le point pour le score est requis.',
            'ptscore.int' => 'Le point pour le score doit être un nombre.',
        ];

        return [
            'regles' => $regles,
            'messages' => $messages,
        ];
    }

    //Pour créer un nouveau  match
    public static function ajouterMatch($idtournoi,$idtypematch,$datematch,$finmatch,$idequipe1,$idequipe2,$stade,$ptresultat,$ptscore,$avecresultat){
        return self::create([
            'idtournoi' => $idtournoi,
            'idtypematch' => $idtypematch,
            'datematch' => $datematch,
            '$finmatch' => $$finmatch,
            'idequipe1' => $idequipe1,
            'idequipe2' => $idequipe2,
            'ptresultat' => $ptresultat,
            'ptscore' => $ptscore,
            'avecresultat' => $avecresultat,
        ]);
    }

    //Pour modifier un match
    public function modifierMatch($idtournoi,$idtypematch,$datematch,$finmatch,$idequipe1,$idequipe2,$stade,$ptresultat,$ptscore,$avecresultat){
        $this->nomtypematch = $nomtypematch;
        $this->idphase = $idphase;
        $this->save();
    }

    //Pour effacer un match
    public function effacerMatch(){
        //Supprimer le match lui-même
        $this->delete();
    }
}