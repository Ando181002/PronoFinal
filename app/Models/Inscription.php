<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Inscription extends Model
{
    use HasFactory;

    public $timestamps=false;
    protected $table = 'inscription';
    protected $primaryKey='idinscription';
    protected $fillable = ['idtournoi','dateinscription','trigramme','equipe1g','equipe2g','reponsequestion'];

    public function Tournoi()
    {
        return $this->belongsTo(Tournoi::class, 'idtournoi');
    }  
    public function Compte()
    {
        return $this->belongsTo(Compte::class, 'trigramme');
    }  
    public function Equipe1()
    {
        return $this->belongsTo(Equipe::class, 'equipe1g');
    }  
    public function Equipe2()
    {
        return $this->belongsTo(Equipe::class, 'equipe2g');
    }
    public function pronostics(){
        return $this->hasMany(Pronostic::class,'idinscription');
    }
    
    //Pour créer une nouvelle inscription
    public static function ajouterInscription($trigramme,$dateinscription,$idtournoi,$idequipe1g,$idequipe2g,$reponsequestion){
        return self::create([
            'trigramme' => $trigramme,
            'dateinscription' => $dateinscription,
            'idtournoi' => $idtournoi,
            'equipe1g' => $idequipe1g,
            'equipe2g' => $idequipe2g,
            'reponsequestion' => $reponsequestion,
        ]);
    }

    public function pointSupplementaire(){
        $tournoi=Tournoi::find($this->idtournoi);
        $finalistes=$tournoi->equipesFinalistes();
        $gagnante1=$this->equipe1g;
        $gagnante2=$this->equipe2g;
        $pointsupp=0;
        if(in_array($gagnante1,$finalistes)){
            if(in_array($gagnante2,$finalistes)){
                $pointsupp=50;
            }
        }
        return $pointsupp;
    }

    public function pointParPhase($idphase){
        $points=0;
        $tournoi=Tournoi::find($this->idtournoi);
        if($idphase==0){
            $matchs=$tournoi->matchs;
        }
        else{
            $matchs=$tournoi->matchsParPhase($idphase);
        }
        foreach($matchs as $match){
            $point=0;
            $pronostic=$match->pronostics()->where('idinscription',$this->idinscription)->first();
            if($pronostic){
                $point=$pronostic->totalpoint();
            }
            $points=$points+$point;       
        }
        if($idphase==0){
            $points=$points+$this->pointSupplementaire();
        }
        return $points;
    }
    public function pronosticParMatch($idmatch){
        $prono=null;
        $pronostics=$this->pronostics;
        foreach($pronostics as $pronostic){
            if($pronostic->idmatch==$idmatch){
                $prono=$pronostic;
            }
        }
        return $prono;
    }
    public function pointParMatch($idmatch){
        $pronostic=$this->pronosticParMatch($idmatch);
        $points=[0,0];
        if($pronostic!=null){
            $points=$pronostic->points();
        }
        return $points;
    }
}