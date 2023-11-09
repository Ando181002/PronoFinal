<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Validation\Rule;

class TypeMatch extends Model
{
    use HasFactory;

    public $timestamps=false;
    protected $table = 'typematch';
    protected $primaryKey='idtypematch';
    protected $fillable = ['nomtypematch','idphase'];

    public function PhaseJeu()
    {
        return $this->belongsTo(PhaseJeu::class, 'idphase');
    }
    //On gère les règles de validation  des attributs
    public static function reglesValidation($contexte){
        $regles = [
            'nomtypematch' => 'required|string',
            'idphase' => 'required|int',
        ];
        $messages = [
            'nomtypematch.required' => 'Le nom de type de match est requis.',
            'nomtypematch.string' => 'Le nom de type de match doit être une chaîne de caractères.',
            'idphase.required' => 'La phase de jeu est requise.',
        ];
        if($contexte === 'creation'){
            $regles['nomtypematch'] .= '|unique:typematch,nomtypematch';
            $messages['nomtypematch'] = 'Le nom de type de match existe déjà.';
        }
        return [
            'regles' => $regles,
            'messages' => $messages,
        ];
    }

    //Relation: un type de match peut avoir plusieurs matchs
    public function Matchs(){
        return $this->hasMany(Matchs::class);
    }

    //Pour créer un nouveau type de match
    public static function ajouterTypeMatch($nomtypematch,$idphase){
        return self::create([
            'nomtypematch' => $nomtypematch,
            'idphase' => $idphase,
        ]);
    }

    //Pour modifier un type de match
    public function modifierTypeMatch($nomtypematch,$idphase){
        $this->nomtypematch = $nomtypematch;
        $this->idphase = $idphase;
        $this->save();
    }

    //Pour effacer un type de match
    public function effacerTypeMatch(){
        //Supprimer les matchs associés à ce type de match
        $this->Matchs()->delete();

        //Supprimer le type de match lui-même
        $this->delete();
    }
}