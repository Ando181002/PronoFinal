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

    //Pour récupérer le resultat à comparer avec le pronostic émis
    public function resultatAComparer(){
        $idmatch=$this->idmatch;
        $resultat=ResultatMatch::where('idmatch','=',$idmatch)->get();
        return $resultat;
    }



}

