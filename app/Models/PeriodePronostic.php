<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class PeriodePronostic extends Model
{
    use HasFactory;

    public $timestamps=false;
    protected $table = 'periodepronostic';
    protected $primaryKey='idperiodepronostic';
    protected $fillable = ['numjour','nomjour','limite'];

    //On gère les règles de validation  des attributs
    public static function reglesValidation($contexte){
        $regles = [
            'numjour' => 'required|int',
            'limite' => 'required|int',
            'nomjour' => 'required|string',
        ];
        $messages = [
            'numjour.required' => 'Le numéro du jour est requis.',
            'numjour.int' => 'Le numéro du jour doit être un nombre.',
            'limte.required' => 'Le date limite de pronostic est requise.',
            'limte.int' => 'Le date limite de pronostic doit être un nombre.',
        ];
        if($contexte === 'creation'){
            $regles['numjour'] .= '|unique:periodepronostic,numjour';
            $messages['numjour'] = 'Ce numéro de jour existe déjà.';
            $regles['nomjour'] .= '|unique:periodepronostic,nomjour';
            $messages['nomjour'] = 'Le nom de type d\'activité existe déjà.';
        }
        return [
            'regles' => $regles,
            'messages' => $messages,
        ];
    }

    //Pour créer une nouvelle période
    public static function ajouterPeriode($numjour,$nomjour,$limite){
        return self::create([
            'numjour' => $numjour,
            'nomjour' => $nomjour,
            'limite' => $limite,
        ]);
    }

    //Pour modifier une période
    public function modifierPeriode($numjour,$nomjour,$limite){
        $this->numjour = $numjour;
        $this->nomjour = $nomjour;
        $this->limite = $limite;
        $this->save();
    }
 
}