<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Validation\Rule;


class Vainqueur extends Model
{
    use HasFactory;

    public $timestamps=false;
    protected $table = 'vainqueur';
    protected $primaryKey='idvainqueur';
    protected $fillable = ['idtournoi','trigramme','montant','points','rang'];

    //Relation: une vainqueur appartient à un tournoi
    public function Tournoi(){
        return $this->belongsTo(Vainqueur::class, 'idtournoi');
    }

    //Relation: une vainqueur est associé à un compte
    public function Compte(){
        return $this->belongsTo(Compte::class, 'idcompte');
    }

    //On gère les règles de validation  des attributs
    public static function reglesValidation($contexte){
        $regles = [
            'trigramme' => 'required|string|size:3',
            'montant' => 'required|numeric',
        ];
        $messages = [
            'trigramme.required' => 'Le trigramme est requis.',
            'trigramme.string' => 'Le trigramme doit être une chaîne de caractères.',
            'trigramme.size' => 'Le trigramme doit être composé de 3 lettres.',
            'montant.required' => 'Le montant est requis.',
            'montant.numeric' => 'Le montant doit être valide.',
        ];
        return [
            'regles' => $regles,
            'messages' => $messages,
        ];
    }

    //Pour créer un nouveau vainqueur
    public static function ajouterVainqueur($idtournoi,$trigramme,$montant,$points,$rang){
        return self::create([
            'idtournoi' => $idtournoi,
            'trigramme' => $trigramme,
            'montant' => $montant,
            'points' => $points,
            'rang' => $rang,
        ]);
    }

}