<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Equipe extends Model
{
    use HasFactory;

    public $timestamps=false;
    protected $table = 'equipe';
    protected $primaryKey='idequipe';
    protected $fillable = ['nomequipe','imageequipe'];

    //On gère les règles de validation  des attributs
    public static function reglesValidation($contexte){
        $regles = [
            'nomequipe' => 'required|string',
        ];
        $messages = [
            'nomequipe.required' => 'Le nom de l\'equipe est requis.',
            'nomequipe.string' => 'Le nom de l\'equipe doit être une chaîne de caractères.',
        ];
        if($contexte === 'creation'){
            $regles['nomequipe'] .= '|unique:equipe,nomequipe';
            $messages['nomequipe'] = 'Le nom de l\'equipe existe déjà.';
        }
        return [
            'regles' => $regles,
            'messages' => $messages,
        ];
    }

    //Relation: une equipe peut être dans plusieurs types de tournoi
    public function typetournois(){
        return $this->belongsToMany(TypeTournoi::class,'equipe_typetournoi','idequipe','idtypetournoi');
    }

    //Pour créer une nouvelle equipe
    public static function ajouterEquipe($nomequipe,$imageequipe){
        return self::create([
            'nomequipe' => $nomequipe,
            'imageequipe' => $imageequipe,
        ]);
    }

    //Pour modifier une equipe
    public function modifierEquipe($nomequipe){
        $this->nomequipe = $nomequipe;
        $this->save();
    }

    //Pour effacer une equipe
    public function effacerEquipe(){
        $this->delete();
    }
}