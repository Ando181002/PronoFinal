<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Pronostic extends Model
{
    use HasFactory;

    public $timestamps=false;
    protected $table = 'pronostic';
    protected $primaryKey='idpronostic';
    protected $fillable = ['idmatch','datepronostic','prono1','prono2','idinscription'];

    public function Inscription()
    {
        return $this->belongsTo(Inscription::class, 'idinscription');
    }
    public function Match()
    {
        return $this->belongsTo(Matchs::class, 'idmatch');
    }

    public function resultatProno(){
        $match=Matchs::find($this->idmatch);
        $prono1=$this->prono1;
        $prono2=$this->prono2;
        $resultat=$match->idequipe2;
        $score=$prono2;
        if($prono1>$prono2){
            $resultat=$match->idequipe1;
            $score=$prono1;
        }
        $donnees=[$resultat,$score];
        return $donnees;
    }

    public function points(){
        $match=Matchs::find($this->idmatch);
        $resultatProno=$this->resultatProno();
        $resultat=0;
        $score=0;
        if($match->resultat){
            $resultatmatch=$match->resultat->resultatMatch();
            if($resultatProno[0]==$resultatmatch[0]){
                $resultat=$match->ptresultat;
                if($resultatProno[1]==$resultatmatch[1]){
                    $score=$match->ptscore;
                }
                else{
                    $score=0;
                }
            }
        }
        $points=[$resultat,$score];
        return $points;
    }

    public function totalpoint(){
        return $this->points()[0]+$this->points()[1];
    }

    //On gère les règles de validation  des attributs
    public static function reglesValidation($contexte){
        $regles = [
            'prono1' => 'required|int',
            'prono2' => 'required|int',
        ];
        $messages = [
            'prono1.required' => 'Le score1 est requis.',
            'prono1.int' => 'Le point pour le score1 doit être un nombre.',
            'prono2.required' => 'Le score2 est requis.',
            'prono2.int' => 'Le point pour le score2 doit être un nombre.',
        ];

        return [
            'regles' => $regles,
            'messages' => $messages,
        ];
    }

     //Pour créer un nouveau  pronostic
     public static function ajouterPronostic($idmatch,$idinscription,$prono1,$prono2,$datepronostic){
        return self::create([
            'idmatch' => $idmatch,
            'idinscription' => $idinscription,
            'prono1' => $prono1,
            'prono2' => $prono2,
            'datepronostic' => $datepronostic,
        ]);
    }

    //Pour modifier un pronostic
    public function modifierPronostic($prono1,$prono2){
        $this->prono1 = $prono1;
        $this->prono2 = $prono2;
        $this->save();
    }

    //Pour effacer un pronostic
    public function effacerPronostic(){
        $this->delete();
    }
}

