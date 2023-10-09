<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class ResultatPris extends Model
{
    use HasFactory;

    public $timestamps=false;
    protected $table = 'resultatpris';
    protected $primaryKey='idresultatpris';
    protected $fillable = ['idtournoi','idmatch'];

    public function Tournoi()
    {
        return $this->belongsTo(Tournoi::class, 'idtournoi');
    }
    public function Matchs()
    {
        return $this->belongsTo(Matchs::class, 'idmatch');
    }
    
}