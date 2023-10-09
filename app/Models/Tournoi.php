<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Tournoi extends Model
{
    use HasFactory;

    public $timestamps=false;
    protected $table = 'tournoi';
    protected $primaryKey='idtournoi';
    protected $fillable = ['nomtournoi','idtypetournoi','debuttournoi','fintournoi','descri','frais','question','imagetournoi','rang1','rang2','rang3','rang4','rang5','datepublication'];

    public function TypeTournoi()
    {
        return $this->belongsTo(TypeTournoi::class, 'idtypetournoi');
    }
}