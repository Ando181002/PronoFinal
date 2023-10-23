<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class ResultatMatch extends Model
{
    use HasFactory;

    public $timestamps=false;
    protected $table = 'resultatmatch';
    protected $primaryKey='idresultatmatch';
    protected $fillable = ['idmatch','dateresultat','score1','score2'];

    public function Matchs()
    {
        return $this->belongsTo(Matchs::class, 'idmatch');
    }

    public function resultatMatch(){
        $match=Matchs::find($this->idmatch);
        $score1=$this->score1;
        $score2=$this->score2;
        $resultat=$match->idequipe2;
        $score=$score2;
        if($score1>$score2){
            $resultat=$match->idequipe1;
            $score=$score1;
        }
        $donnees=[$resultat,$score];
        return $donnees;
    }
     //On gère les règles de validation  des attributs
    public static function reglesValidation($contexte){
        $regles = [
            'score1' => 'required|int',
            'score2' => 'required|int',
        ];
        $messages = [
            'score1.required' => 'Le score1 est requis.',
            'score1.int' => 'Le point pour le score1 doit être un nombre.',
            'score2.required' => 'Le score2 est requis.',
            'score2.int' => 'Le point pour le score2 doit être un nombre.',
        ];

        return [
            'regles' => $regles,
            'messages' => $messages,
        ];
    }

     //Pour créer un nouveau  resultat de match
     public static function ajouterResultatMatch($idmatch,$dateresultat,$score1,$score2){
        return self::create([
            'idmatch' => $idmatch,
            'dateresultat' => $dateresultat,
            'score1' => $score1,
            'score2' => $score2,
        ]);
    }

    //Pour modifier un match
    public function modifierResultatMatch($idresulat,$dateresultat,$score1,$score2){
        $this->idresultat = $idresultat;
        $this->dateresultat = $dateresultat;
        $this->score1 = $score1;
        $this->score2 = $score2;
        $this->save();
    }

    //Pour effacer un match
    public function effacerResultatMatch(){
        //Supprimer le match lui-même
        $this->delete();
    }


    
}