<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class TypeMatch extends Model
{
    use HasFactory;

    public $timestamps=false;
    protected $table = 'typematch';
    protected $primaryKey='idtypematch';
    protected $fillable = ['nomtypematch','idphase'];

    public function PhaseJeu()
    {
        return $this->belongsTo(PhaseJeu::class, 'idphase');
    }
}