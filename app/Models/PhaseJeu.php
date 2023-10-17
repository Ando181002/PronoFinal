<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Validation\Rule;


class PhaseJeu extends Model
{
    use HasFactory;

    public $timestamps=false;
    protected $table = 'phasejeu';
    protected $primaryKey='idphase';
    protected $fillable = ['nomphase'];

    //On gère les règles de validation  des attributs
    public static function reglesValidation($contexte){
        $regles = [
            'nomphase' => 'required|string',
        ];
        $messages = [
            'nomphase.required' => 'Le nom de phase est requis.',
            'nomphase.string' => 'Le nom de phase doit être une chaîne de caractères.',
        ];
        if($contexte === 'creation'){
            $regles['nomphase'] .= '|unique:phasejeu,nomphase';
            $messages['nomphase'] = 'Le nom de phase existe déjà.';
        }
        return [
            'regles' => $regles,
            'messages' => $messages,
        ];
    }

    //Relation: une phase de jeu peut avoir plusieurs types de match
    public function TypeMatchs(){
        return $this->hasMany(TypeMatch::class);
    }

    //Pour créer une nouvelle phase de jeu
    public static function ajouterPhaseJeu($nomphase){
        return self::create([
            'nomphase' => $nomphase,
        ]);
    }

    //Pour modifier une phase de jeu
    public function modifierPhaseJeu($nomphase){
        $this->nomphase = $nomphase;
        $this->save();
    }

    //Pour effacer une phase de jeu
    public function effacerPhaseJeu(){
        //Supprimer les types de matchs associés à ce phase
        $this->TypeMatchs()->delete();

        //Supprimer la phase de jeu elle-même
        $this->delete();
    }
}