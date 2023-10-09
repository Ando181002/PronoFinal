<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Equipe extends Model
{
    use HasFactory;

    public $timestamps=false;
    protected $table = 'equipe';
    protected $primaryKey='idequipe';
    protected $fillable = ['nomequipe','imageequipe'];
}