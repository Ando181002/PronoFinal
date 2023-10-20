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

    public function setFinmatchAttribute($datematch){
        $typetournoi=TypeTournoi::find($this->idtournoi);
        $this->attributes['finmatch'] = $typetournoi->calculerFinMatch($dateMatch);
    }

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

    //Un match a seulement un résultat
    public function resultat()
    {
        return $this->hasOne(ResultatMatch::class);
    }

    //Un match peut avoir plusieurs pronostics
    public function pronostics()
    {
        return $this->hasMany(Pronostic::class,'idmatch');
    }

     //On gère les règles de validation  des attributs
     public static function reglesValidation($contexte){
        $regles = [
            'ptresultat' => 'required|int',
            'ptscore' => 'required|int',
            'datematch' => 'required|date_format:Y-m-d H:i',
        ];
        $messages = [
            'ptresultat.required' => 'Le point pour le resultat est requis.',
            'ptresultat.int' => 'Le point pour le resultat doit être un nombre.',
            'ptscore.required' => 'Le point pour le score est requis.',
            'ptscore.int' => 'Le point pour le score doit être un nombre.',
            'datematch.required' => 'La date du match est requise.',
            'datematch.date_format' => 'Le champ Date de match doit être au format "jour-mois-année heure:minute".',
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
            'finmatch' => $finmatch,
            'idequipe1' => $idequipe1,
            'idequipe2' => $idequipe2,
            'ptresultat' => $ptresultat,
            'ptscore' => $ptscore,
            'avecresultat' => $avecresultat,
        ]);
    }

    //Pour modifier un match
    public function modifierMatch($idtournoi,$idtypematch,$datematch,$finmatch,$idequipe1,$idequipe2,$stade,$ptresultat,$ptscore,$avecresultat){
        $this->idtournoi = $idtournoi;
        $this->idtypematch = $idtypematch;
        $this->datematch = $datematch;
        $this->finmatch = $finmatch;
        $this->idequipe1 = $idequipe1;
        $this->idequipe2 = $idequipe2;
        $this->stade = $stade;
        $this->ptresultat = $ptresultat;
        $this->ptscore = $ptscore;
        $this->avecresultat = $avecresultat;
        $this->save();
    }

    //Pour effacer un match
    public function effacerMatch(){
        //Supprimer le match lui-même
        $this->delete();
    }

    //Recupérer les matchs sans résultat
    public function scopeSansResultat($query){
        return $query->where('avecresultat','=','0');
    }

    //Recupérer les matchs avec résultat
    public function scopeAvecResultat($query){
        return $query->where('avecresultat','=','1');
    }

    //Recupérer le classement
    public function classement(){
        $idmatch=$this->idmatch;
        $classement=DB::table('classement')
            ->join('inscription', 'classement.idinscription', '=', 'inscription.idinscription')
            ->where('idmatch', $idmatch)
            ->orderBy('total', 'desc')
            ->limit(5)
            ->get();
        return $classement;
    }
}