<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Validation\Rule;


class Activite extends Model
{
    use HasFactory;

    public $timestamps=false;
    protected $table = 'activite';
    protected $primaryKey='idactivite';
    protected $fillable = ['nomactivite','idtypeactivite'];

    //On gère les règles de validation  des attributs
    public static function reglesValidation($contexte){
        $regles = [
            'nomactivite' => 'required|string',
        ];
        $messages = [
            'nomactivite.required' => 'Le nom d\'activité est requis.',
            'nomactivite.string' => 'Le nom d\'activité doit être une chaîne de caractères.',
        ];
        if($contexte === 'creation'){
            $regles['nomactivite'] .= '|unique:activite,nomactivite';
            $messages['nomactivite'] = 'Le nom d\'activité existe déjà.';
        }
        return [
            'regles' => $regles,
            'messages' => $messages,
        ];
    }

    //Relation: une activité appartient à un type d'activité
    public function TypeActivite(){
        return $this->belongsTo(TypeActivite::class, 'idtypeactivite');
    }

    //Relation: une activité peut être dans plusieurs évènements
    public function evenements(){
        return $this->belongsToMany(Evenement::class,'evenement_activite','idactivite','idevenement')->withPivot('dureeactivite','nombrejoueur','idgenre');
    }

    //Pour créer une nouvelle activité
    public static function ajouterActivite($nomActivite,$idTypeActivite){
        return self::create([
            'nomactivite' => $nomActivite,
            'idtypeactivite' => $idTypeActivite,
        ]);
    }

    //Pour modifier une activité
    public function modifierActivite($nomActivite,$idTypeActivite){
        $this->nomactivite = $nomActivite;
        $this->idtypeactivite = $idTypeActivite;
        $this->save();
    }

    //Pour effacer une activité
    public function effacerActivite(){
        $this->delete();
    }

    //Pour récuperer toutes les activités par type d'activité
    public static function recupererActiviteParType($idTypeActivite){
        return self::where('idtypeactivite',$idTypeActivite)->get();
    }
}