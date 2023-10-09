<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class ResultatMatch extends Model
{
    use HasFactory;

    public $timestamps=false;
    protected $table = 'resultatmatch';
    protected $primaryKey='idresultatmatch';
    protected $fillable = ['idmatch','dateresultat','score1','score2'];

    public function Matchs()
    {
        return $this->belongsTo(Matchs::class, 'idmatch');
    }
    
}