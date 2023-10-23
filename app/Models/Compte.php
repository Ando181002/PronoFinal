<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Validation\Rule;

class Compte extends Model
{
    use HasFactory;

    public $timestamps=false;
    public $incrementing = false;
    protected $table = 'compte';
    protected $primaryKey='trigramme';
    protected $fillable = ['trigramme','nom','datenaissance','idgenre','email','mdp','telephone','idtypepersonnel','iddepartement'];

    public function Genre()
    {
        return $this->belongsTo(Genre::class, 'idgenre');
    }
    public function TypePersonnel()
    {
        return $this->belongsTo(TypePersonnel::class, 'idtypepersonnel');
    }
    public function Departement()
    {
        return $this->belongsTo(Departement::class, 'iddepartement');
    }

    //Un compte peut faire plusieurs inscriptions
    public function inscriptions(){
        return $this->hasMany(Inscription::class,'trigramme');
    }

    //Un compte peut être plusieurs vainqueurs
    public function vainqueurs(){
        return $this->hasMany(Vainqueur::class,'trigramme');
    }

    //On gère les règles de validation  des attributs
     public static function reglesValidation($contexte){
        $regles = [
            'trigramme' => 'required|string|size:3',
            'nom' => 'required|string',
            'datenaissance' => 'required|date',
            'email' => 'required|email',
            'telephone' => 'required|regex:/^032\d{7}$/',
        ];
        $messages = [
            'trigramme.required' => 'Le trigramme est requis.',
            'trigramme.string' => 'Le trigramme doit être une chaîne de caractères.',
            'trigramme.size' => 'Le trigramme doit être composé de 3 lettres.',
            'nom.required' => 'Le nom est requis.',
            'nom.string' => 'Le nom doit être une chaîne de caractères.',
            'datenaissance.required' => 'La date de naissance est requise.',
            'datenaissance.date' => 'La date de naissance doit être une date valide.',
            'email.required' => 'Le email est requis.',
            'email.email' => 'Le email doit être un email valide.',
            'telephone.required' => 'Le numéro de téléphone est requis.',
            'telephone.regex' => 'Le numéro de téléphone doit être un numéro valide.',
        ];
        if($contexte === 'creation'){
            $regles['trigramme'] .= '|unique:compte,trigramme';
            $messages['trigramme'] = 'Ce trigramme existe déjà.';
            $regles['email'] .= '|unique:compte,email';
            $messages['email'] = 'Cet email existe déjà.';
        }
        return [
            'regles' => $regles,
            'messages' => $messages,
        ];
    }

    //Pour créer un nouveau compte
    public static function ajouterCompte($trigramme,$nom,$datenaissance,$idgenre,$email,$mdp,$telephone,$idtypepersonnel,$iddepartement){
        return self::create([
            'trigramme' => $trigramme,
            'nom' => $nom,
            'datenaissance' => $datenaissance,
            'idgenre' => $idgenre,
            'email' => $email,
            'mdp' => $mdp,
            'telephone' => $telephone,
            'idtypepersonnel' => $idtypepersonnel,
            'iddepartement' => $iddepartement,
        ]);
    }

    //Pour modifier un compte
    public function modifierCompte($nom,$datenaissance,$idgenre,$email,$mdp,$telephone,$idtypepersonnel,$iddepartement){
        $this->nom = $nom;
        $this->datenaissance = $datenaissance;
        $this->idgenre = $idgenre;
        $this->email = $email;
        $this->mdp = $mdp;
        $this->telephone = $telephone;
        $this->idtypepersonnel = $idtypepersonnel;
        $this->iddepartement = $iddepartement;
        $this->save();
    }
    
    public function montantGagne(){
        $vainqueurs=Vainqueur::where('trigramme','=',$this->trigramme)->get();
        $montant=0;
        foreach($vainqueurs as $vainqueur){
            $montant=$montant+$vainqueur->montant;
        }
        return $montant;
    }

    public function nombreGagne(){
        $vainqueurs=Vainqueur::where('trigramme','=',$this->trigramme)->get();
        return count($vainqueurs);
    }

    public function nombrePerdu(){
        $inscriptions=count($this->inscriptions);
        $gagne=$this->nombreGagne();
        $perdu=$inscriptions-$gagne;
        return $perdu;
    }

}