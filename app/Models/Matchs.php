<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Matchs extends Model
{
    use HasFactory;

    public $timestamps=false;
    protected $table = 'matchs';
    protected $primaryKey='idmatch';
    protected $fillable = ['idtypematch','idtournoi','datematch','finmatch','stade','idequipe1','idequipe2','ptresultat','ptscore','avecresultat'];

    public function TypeMatch()
    {
        return $this->belongsTo(TypeMatch::class, 'idtypematch');
    }
    public function Tournoi()
    {
        return $this->belongsTo(Tournoi::class, 'idtournoi');
    }
    public function Equipe1()
    {
        return $this->belongsTo(Equipe::class, 'idequipe1');
    }
    public function Equipe2()
    {
        return $this->belongsTo(Equipe::class, 'idequipe2');
    }
}