<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Validation\Rule;

class Tournoi extends Model
{
    use HasFactory;

    public $timestamps=false;
    protected $table = 'tournoi';
    protected $primaryKey='idtournoi';
    protected $fillable = ['nomtournoi','idtypetournoi','debuttournoi','fintournoi','descri','frais','question','imagetournoi','rang1','rang2','rang3','rang4','rang5','datepublication'];

    //On gère les règles de validation  des attributs
    public static function reglesValidation($contexte){
        $regles = [
            'nomtournoi' => 'required|string',
            'debuttournoi' => 'required|date',
            'fintournoi' => 'required|date|after:debuttournoi',
            'frais' => 'required|numeric',
            'rang1' => 'required|int',
            'rang2' => 'required|int',
            'rang3' => 'required|int',
            'rang4' => 'required|int',
            'rang5' => 'required|int',
        ];
        $messages = [
            'nomtournoi.required' => 'Le nom de tournoi est requis.',
            'nomtournoi.string' => 'Le nom de tournoi doit être une chaîne de caractères.',
            'debuttournoi.required' => 'La date de debut du tournoi est requise.',
            'debuttournoi.date' => 'La date de début du tournoi doit être une date valide.',
            'fintournoi.required' => 'La date de fin du tournoi est requise.',
            'fintournoi.date' => 'La date de fin du tournoi doit être une date valide.',
            'fintournoi.after' => 'La date de fin du tournoi doit être postérieure à la date de début du tournoi.',
            'frais.required' => 'Le frais du tournoi est requis.',
            'frais.numeric' => 'Le frais du tournoi doit être un montant valide.',
            'rang1.required' => 'Le pourcentage pour le vainqueur n°1 du tournoi est requis.',
            'rang1.int' => 'Le pourcentage doit être un nombre.',
            'rang2.required' => 'Le pourcentage pour le vainqueur n°2 du tournoi est requis.',
            'rang2.int' => 'Le pourcentage doit être un nombre.',
            'rang3.required' => 'Le pourcentage pour le vainqueur n°3 du tournoi est requis.',
            'rang3.int' => 'Le pourcentage doit être un nombre.',
            'rang4.required' => 'Le pourcentage pour le vainqueur n°4 du tournoi est requis.',
            'rang4.int' => 'Le pourcentage doit être un nombre.',
            'rang5.required' => 'Le pourcentage pour le vainqueur n°5 du tournoi est requis.',
            'rang5.int' => 'Le pourcentage doit être un nombre.',
        ];
        if($contexte === 'creation'){
            $regles['nomtournoi'] .= '|unique:tournoi,nomtournoi';
            $messages['nomtournoi'] = 'Le nom de tournoi existe déjà.';
        }
        return [
            'regles' => $regles,
            'messages' => $messages,
        ];
    }
    
    //Relation: un tournoi appartient à un type de tournoi
    public function TypeTournoi(){
        return $this->belongsTo(TypeTournoi::class, 'idtypetournoi');
    }

    //Relation: un tournoi peut avoir plusieurs matchs
    public function matchs(){
        return $this->hasMany(Matchs::class,'idtournoi');
    }

    //Relation: un tournoi peut avoir plusieurs participants
    public function inscriptions(){
        return $this->hasMany(Inscription::class,'idtournoi');
    }

    //Pour créer un nouveau tournoi
    public static function ajouterTournoi($nomtournoi,$idtypetournoi,$debuttournoi,$fintournoi,$descri,$frais,$question,$imagetournoi,$datepublication,$rang1,$rang2,$rang3,$rang4,$rang5){
        return self::create([
            'nomtournoi' => $nomtournoi,
            'idtypetournoi' => $idtypetournoi,
            'debuttournoi' => $debuttournoi,
            'fintournoi' => $fintournoi,
            'descri' => $descri,
            'frais' => $frais,
            'question' => $question,
            'imagetournoi' => $imagetournoi,
            'datepublication' => $datepublication,
            'rang1' => $rang1,
            'rang2' => $rang2,
            'rang3' => $rang3,
            'rang4' => $rang4,
            'rang5' => $rang5,
        ]);
    }

    //Pour modifier un de tournoi
    public function modifierTypeTournoi($nomtournoi,$idtypetournoi,$debuttournoi,$fintournoi,$descri,$frais,$question,$rang1,$rang2,$rang3,$rang4,$rang5){
        $this->nomtournoi = $nomtournoi;
        $this->idtypetournoi = $idtypetournoi;
        $this->debuttournoi = $debuttournoi;
        $this->fintournoi = $fintournoi;
        $this->descri = $descri;
        $this->frais = $frais;
        $this->question = $question;
        $this->rang1 = $rang1;
        $this->rang2 = $rang2;
        $this->rang3 = $rang3;
        $this->rang4 = $rang4;
        $this->rang5 = $rang5;
        $this->save();
    }

    //Pour effacer un tournoi
    public function effacerTournoi(){
        //Supprimer les matchs associés à ce tournoi
        $this->Matchs()->delete();

        //Supprimer le tournoi lui-même
        $this->delete();
    }

    //Pour récupérer le nombre d'inscriptions
    public function nombreInscriptions(){
        $inscriptions=$this->inscriptions;
        $nombre=count($inscriptions);
        return $nombre;
    }

    //Pour récupérer le montant de la cagnote
    public function montantCagnote(){
        return $this->nombreInscriptions()*$this->frais;
    }

    //Pour récuperer tous les tournois par type de tournoi
    public static function recupererTournoiParType($idtypetournoi){
        return self::where('idtypetournoi',$idtypetournoi)->get();
    }

    public function equipesFinalistes(){
        $idtournoi=$this->idtournoi;
        $typematch=TypeMatch::where('nomtypematch','=','Finale')->first();
        $matchfinal=Matchs::where('idtournoi','=',$idtournoi)->where('idtypematch','=',$typematch->idtypematch)->first();
        $finalistes=[0,0];
        if($matchfinal){
            $finalistes=[$matchfinal->idequipe1,$matchfinal->idequipe2];
        }
        return $finalistes;
    }

    public function vainqueurs(){
        $inscriptions=$this->inscriptions;
        $inscriptions=$inscriptions->sortByDesc(function($inscription){
            return $inscription->pointParPhase(0);
        });
        $vainqueurs=$inscriptions->take(5);
        $rang=1;
        $cagnote=$this->montantCagnote();
        foreach($vainqueurs as $vainqueur){
            $vainqueur->rang=$rang;
            $recompense="rang".$rang;
            $vainqueur->montant=$cagnote*($this->$recompense/100);
            $rang++;
        }
        return $vainqueurs;
    }

    public function matchsParPhase($idphase){
        $matchs=$this->matchs();
        if($idphase != 0){
            $matchs->whereHas('typematch',function($matchs) use ($idphase){
                $matchs->where('idphase', $idphase);
            });  
        }   
        $matchs=$matchs->get();   
        return $matchs;
    }
}