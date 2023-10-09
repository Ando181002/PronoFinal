<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class PeriodePronostic extends Model
{
    use HasFactory;

    public $timestamps=false;
    protected $table = 'periodepronostic';
    protected $primaryKey='idperiodepronostic';
    protected $fillable = ['numjour','nomjour','limite'];
}