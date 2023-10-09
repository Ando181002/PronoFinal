<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class PhaseJeu extends Model
{
    use HasFactory;

    public $timestamps=false;
    protected $table = 'phasejeu';
    protected $primaryKey='idphase';
    protected $fillable = ['nomphase'];
}