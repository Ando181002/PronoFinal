<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Departement extends Model
{
    use HasFactory;

    public $timestamps=false;
    protected $table = 'departement';
    protected $primaryKey='iddepartement';
    protected $fillable = ['nomdepartement'];
}