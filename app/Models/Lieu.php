<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Validation\Rule;

class Lieu extends Model
{
    use HasFactory;

    public $timestamps=false;
    protected $table = 'lieu';
    protected $primaryKey='idlieu';
    protected $fillable = ['nomlieu','imagelieu','latitude','longitude'];

    //On gère les règles de validation  des attributs
    public static function reglesValidation($contexte){
        $regles = [
            'nomlieu' => 'required|string|unique:lieu,nomlieu',
            'latitude' => ['required', 'numeric', 'between:-90.0,90.0'],
            'longitude' => ['required', 'numeric', 'between:-180.0,180.0'],
        ];
        $messages = [
            'nomlieu.required' => 'Le nom du lieu est requis.',
            'nomlieu.string' => 'Le nom du lieu doit être une chaîne de caractères.',
            'nomlieu.unique' => 'ce lieu existe déjà.',
            'latitude.required' => 'La latitude est requise.',
            'latitude.numeric' => 'La latitude doit être un nombre.',
            'latitude.between' => 'La latitude doit être comprise entre -90 et 90 degrés.',
            'longitude.required' => 'La longitude est requise.',
            'longitude.numeric' => 'La longitude doit être un nombre.',
            'longitude.between' => 'La longitude doit être comprise entre -180 et 180 degrés.',   
        ];

        return [
            'regles' => $regles,
            'messages' => $messages,
        ];
    }

    //Pour créer un nouveau lieu
    public static function ajouterLieu($nomlieu,$imagelieu,$latitude,$longitude){
        return self::create([
            'nomlieu' => $nomlieu,
            'imagelieu' => $imagelieu,
            'latitude' => $latitude,
            'longitude' => $longitude,
        ]);
    }

    //Pour modifier un lieu
    public static function modifierLieu($nomlieu,$imagelieu,$latitude,$longitude){
        $this->nomlieu = $nomlieu;
        $this->imagelieu = $imagelieu;
        $this->latitude = $latitude;
        $this->longitude = $longitude;
        $this->save();
    }

    //Pour effacer un lieu
    public function effacerLieu(){
        $this->delete();
    }
}