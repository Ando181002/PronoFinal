<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Evenement extends Model
{
    use HasFactory;

    public $timestamps=false;
    protected $table = 'evenement';
    protected $primaryKey='idevenement';
    protected $fillable = ['nomevenement','dateevenement','fininscription','idlieu','imageEvenement'];

    //On gère les règles de validation  des attributs
    public static function reglesValidation($contexte){
        $regles = [
            'nomevenement' => 'required|string',
            'dateevenement' => 'required|date',
        ];
        $messages = [
            'nomevenement.required' => 'Le nom de l\'évènement est requis.',
            'nomevenement.string' => 'Le nom de l\'évènement doit être une chaîne de caractères.',
            'dateevenement.required' => 'La date de l\'évènement est requise.',
            'dateevenement.date' => 'La date de l\'évènement doit être une date valide.',    
        ];
        if($contexte === 'creation'){
            $regles['nomevenement'] .= '|unique:evenement,nomevenement';
            $messages['nomevenement'] = 'Le nom de l\'évènement existe déjà.';
        }
        return [
            'regles' => $regles,
            'messages' => $messages,
        ];
    }

    //Relation: un lieu pour un evenement
    public function Lieu(){
        return $this->belongsTo(Lieu::class, 'idlieu');
    }

    //Relation: un évènement peut avoir plusieurs activités
    public function activites(){
        return $this->belongsToMany(Activite::class,'evenement_activite','idevenement','idactivite')->withPivot('idevenement_activite','dureeactivite','nombrejoueur','idgenre');
    }

    //Pour créer un nouvel evenement
    public static function ajouterEvenement($nomevenement,$dateevenement,$fininscription,$idlieu,$imageevenement){
        return self::create([
            'nomevenement' => $nomevenement,
            'dateevenement' => $dateevenement,
            'fininscription' => $fininscription,
            'idlieu' => $idlieu,
            'imageevenement' => $imageevenement,
        ]);
    }

    //Pour modifier un évènement
    public function modifierEvenement($nomevenement,$dateevenement,$fininscription,$idlieu,$imageevenement){
        $this->nomevenement = $nomevenement;
        $this->dateevenement = $dateevenement;
        $this->fininscription = $fininscription;
        $this->idlieu = $idlieu;
        $this->imageevenement = $imageevenement;
        $this->save();
    }

    //Pour effacer un évènement
    public function effacerEvenement(){
        $this->delete();
    }

    //Recupérer les évènements passés
    public function scopeEvenementPasse($query){
        return $query->where('dateevenement','<',now());
    }

    //Recupérer les évènements à venir
    public function scopeEvenementAvenir($query){
        return $query->where('dateevenement','>',now());
    }

    //Voir le temps restant avant la fin de l'inscription
    public function tempsRestantInscription(){
        $maintenant=now();
        $finInscription=$this->fininscription;
        //Verifier si la date d'inscription est dans le futur
        if($finInscription > $maintenant){
            return $finInscription->diffForHumans($maintenant);
        }
        else{
            return "Inscription terminée";
        }
    }

    //Ajouter une activité à un évènement
    public function ajouterActivite($idactivite,$dureeactivite,$nombrejoueur,$idgenre){
        $this->activites()->attach($idactivite,['dureeactivite' => $dureeactivite, 'nombrejoueur' => $nombrejoueur, 'idgenre' => $idgenre]);
    }

    //Modifier une activité à un évènement
    public function modifierActivite($idevenement_activite,$dureeactivite,$nombrejoueur,$idgenre){
        DB::table('evenement_activite')
        ->where('idevenement_activite', $idevenement_activite)
        ->update([
            'dureeactivite' => $dureeactivite,
            'nombrejoueur' => $nombrejoueur,
            'idgenre' => $idgenre,
        ]);  
    }

    //Supprimer une activité d'un évènement
    public function supprimerActivite($idevenement_activite){
        DB::table('evenement_activite')
            ->where('idevenement_activite', $idevenement_activite)
            ->delete();    }

    //Récupérer toutes les activités collectives
    public function activitesCollectives(){
        return $this->activites()
            ->whereHas('idtypeactivite',function($requete){
                $requete->where('idtypeactivite','collective');
            });
    }

    //Récupérer toutes les activités individuelles
    public function activitesIndividuelles(){
        return $this->activites()
            ->whereHas('idtypeactivite',function($requete){
                $requete->where('nomtypeactivite','individuelle');
            });
    }

}