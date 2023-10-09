<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Inscription extends Model
{
    use HasFactory;

    public $timestamps=false;
    protected $table = 'inscription';
    protected $primaryKey='idinscription';
    protected $fillable = ['idtournoi','dateinscription','trigramme','idequipe1g','idequipe2g','reponseQuestion'];

    public function Tournoi()
    {
        return $this->belongsTo(Tournoi::class, 'idtournoi');
    }  
    public function Compte()
    {
        return $this->belongsTo(Compte::class, 'trigramme');
    }  
    public function Equipe1()
    {
        return $this->belongsTo(Equipe::class, 'idequipe1g');
    }  
    public function Equipe2()
    {
        return $this->belongsTo(Equipe::class, 'idequipe2g');
    }  
}