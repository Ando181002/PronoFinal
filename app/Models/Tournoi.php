<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Tournoi extends Model
{
    use HasFactory;

    public $timestamps=false;
    protected $table = 'tournoi';
    protected $primaryKey='idtournoi';
    protected $fillable = ['nomtournoi','idtypetournoi','debuttournoi','fintournoi','descri','frais','question','imagetournoi','rang1','rang2','rang3','rang4','rang5','datepublication'];

    //On gère les règles de validation  des attributs
    public static function reglesValidation($contexte){
        $regles = [
            'nomtournoi' => 'required|string',
            'debuttournoi' => 'required|date',
            'fintournoi' => 'required|date',
            'frais' => 'required|numeric',
        ];
        $messages = [
            'nomtournoi.required' => 'Le nom de tournoi est requis.',
            'nomtournoi.string' => 'Le nom de tournoi doit être une chaîne de caractères.',
            'debuttournoi.required' => 'La date de debut du tournoi est requise.',
            'debuttournoi.date' => 'La date de début du tournoi doit être une date valide.',
            'fintournoi.required' => 'La date de fin du tournoi est requise.',
            'fintournoi.date' => 'La date de fin du tournoi doit être une date valide.',
            'frais.required' => 'Le frais du tournoi est requis.',
            'frais.numeric' => 'Le frais du tournoi doit être un montant valide.',
        ];
        if($contexte === 'creation'){
            $regles['nomtournoi'] .= '|unique:tournoi,nomtournoi';
            $messages['nomtournoi'] = 'Le nom de tournoi existe déjà.';
        }
        return [
            'regles' => $regles,
            'messages' => $messages,
        ];
    }
    
    //Relation: un tournoi appartient à un type de tournoi
    public function TypeTournoi(){
        return $this->belongsTo(TypeTournoi::class, 'idtypetournoi');
    }

    //Relation: un tournoi peut avoir plusieurs matchs
    public function Matchs(){
        return $this->hasMany(Matchs::class);
    }

    //Relation: un tournoi peut avoir plusieurs participants
    public function Participants(){
        return $this->hasMany(Inscription::class);
    }

    //Pour créer un nouveau tournoi
    public static function ajouterTournoi($nomtournoi,$idtypetournoi,$debuttournoi,$fintournoi,$descri,$frais,$question,$imagetournoi,$datepublication,$rang1,$rang2,$rang3,$rang4,$rang5){
        return self::create([
            'nomtournoi' => $nomtournoi,
            'idtypetournoi' => $idtypetournoi,
            'debuttournoi' => $debuttournoi,
            'fintournoi' => $fintournoi,
            'descri' => $descri,
            'frais' => $frais,
            'question' => $question,
            'imagetournoi' => $imagetournoi,
            'datepublication' => $datepublication,
            'rang1' => $rang1,
            'rang2' => $rang2,
            'rang3' => $rang3,
            'rang4' => $rang4,
            'rang5' => $rang5,
        ]);
    }

    //Pour modifier un de tournoi
    public function modifierTypeTournoi($nomtournoi,$idtypetournoi,$debuttournoi,$fintournoi,$descri,$frais,$question,$rang1,$rang2,$rang3,$rang4,$rang5){
        $this->nomtournoi = $nomtournoi;
        $this->idtypetournoi = $idtypetournoi;
        $this->debuttournoi = $debuttournoi;
        $this->fintournoi = $fintournoi;
        $this->descri = $descri;
        $this->frais = $frais;
        $this->question = $question;
        $this->rang1 = $rang1;
        $this->rang2 = $rang2;
        $this->rang3 = $rang3;
        $this->rang4 = $rang4;
        $this->rang5 = $rang5;
        $this->save();
    }

    //Pour effacer un tournoi
    public function effacerTournoi(){
        //Supprimer les matchs associés à ce tournoi
        $this->Matchs()->delete();

        //Supprimer le tournoi lui-même
        $this->delete();
    }
}