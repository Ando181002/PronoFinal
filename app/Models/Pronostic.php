<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Pronostic extends Model
{
    use HasFactory;

    public $timestamps=false;
    protected $table = 'pronostic';
    protected $primaryKey='idpronostic';
    protected $fillable = ['idmatch','datepronostic','prono1','prono2','idinscription'];

    public function Inscription()
    {
        return $this->belongsTo(Inscription::class, 'idinscription');
    }
    public function Match()
    {
        return $this->belongsTo(Matchs::class, 'idmatch');
    }
}

