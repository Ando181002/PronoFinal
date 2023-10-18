<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Validation\Rule;


class TypeActivite extends Model
{
    use HasFactory;

    public $timestamps=false;
    protected $table = 'typeactivite';
    protected $primaryKey='idtypeactivite';
    protected $fillable = ['nomtypeactivite'];

    //On gère les règles de validation  des attributs
    public static function reglesValidation($contexte){
        $regles = [
            'nomtypeactivite' => 'required|string',
        ];
        $messages = [
            'nomtypeactivite.required' => 'Le nom de type d\'activité est requis.',
            'nomtypeactivite.string' => 'Le nom de type d\'activité doit être une chaîne de caractères.',
        ];
        if($contexte === 'creation'){
            $regles['nomtypeactivite'] .= '|unique:typeactivite,nomtypeactivite';
            $messages['nomtypeactivite'] = 'Le nom de type d\'activité existe déjà.';
        }
        return [
            'regles' => $regles,
            'messages' => $messages,
        ];
    }

    //Relation: un type d'activité peut avoir plusieurs activités
    public function Activites(){
        return $this->hasMany(Activite::class,'idtypeactivite');
    }

    //Pour créer un nouveau type d'activité
    public static function ajouterTypeActivite($nomTypeActivite){
        return self::create([
            'nomtypeactivite' => $nomTypeActivite,
        ]);
    }

    //Pour modifier un type d'activité
    public function modifierTypeActivite($nomTypeActivite){
        $this->nomtypeactivite = $nomTypeActivite;
        $this->save();
    }

    //Pour effacer un type d'activité
    public function effacerTypeActivite(){
        //Supprimer les activités associés à ce type d'activité
        $this->Activites()->delete();

        //Supprimer le type d'activité lui-même
        $this->delete();
    }

}