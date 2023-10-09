<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class TypePersonnel extends Model
{
    use HasFactory;

    public $timestamps=false;
    protected $table = 'typepersonnel';
    protected $primaryKey='idtypepersonnel';
    protected $fillable = ['nomtypepersonnel'];
}