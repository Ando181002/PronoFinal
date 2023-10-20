<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Validation\Rule;
use Carbon\Carbon;

class TypeTournoi extends Model
{
    use HasFactory;

    public $timestamps=false;
    protected $table = 'typetournoi';
    protected $primaryKey='idtypetournoi';
    protected $fillable = ['nomtypetournoi','dureeminute'];

    //On gère les règles de validation  des attributs
    public static function reglesValidation($contexte){
        $regles = [
            'nomtypetournoi' => 'required|string',
            'dureeminute' => 'required|int',
        ];
        $messages = [
            'nomtypetournoi.required' => 'Le nom de type de tournoi est requis.',
            'nomtypetournoi.string' => 'Le nom de type de tournoi doit être une chaîne de caractères.',
            'dureeminute.required' => 'Le durée du tournoi est requise.',
            'dureeminute.int' => 'Le duree du tournoi doit être un nombre.',
        ];
        if($contexte === 'creation'){
            $regles['nomtypetournoi'] .= '|unique:typetournoi,nomtypetournoi';
            $messages['nomtypetournoi'] = 'Le nom de type de tournoi existe déjà.';
        }
        return [
            'regles' => $regles,
            'messages' => $messages,
        ];
    }

    //Relation: un type de tournoi peut avoir plusieurs tournois
    public function tournois(){
        return $this->hasMany(Tournoi::class,'idtypetournoi');
    }

    //Pour créer un nouveau type de tournoi
    public static function ajouterTypeTournoi($nomtypetournoi){
        return self::create([
            'nomtypetournoi' => $nomtypetournoi,
        ]);
    }

    //Pour modifier un type de tournoi
    public function modifierTypeTournoi($nomtypetournoi){
        $this->nomtypetournoi = $nomtypetournoi;
        $this->save();
    }

    //Pour effacer un type de tournoi
    public function effacerTypeTournoi(){
        //Supprimer les tournois associés à ce type de tournoi
        $this->tournois()->delete();

        //Supprimer le type d'activité lui-même
        $this->delete();
    }

    public function calculerFinMatch($dateMatch){
        $dureeMatch = $this->dureeminute;
        $carbonDateTime = Carbon::parse($dateMatch);
        $newCarbonDateTime = $carbonDateTime->addMinutes($dureeMatch);
        $finMatch = $newCarbonDateTime->format('Y-m-d\TH:i');
        return $finMatch;
    }
}