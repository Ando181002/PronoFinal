<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Compte extends Model
{
    use HasFactory;

    public $timestamps=false;
    public $incrementing = false;
    protected $table = 'compte';
    protected $primaryKey='trigramme';
    protected $fillable = ['trigramme','nom','datenaissance','idgenre','email','mdp','telephone','idtypepersonnel','iddepartement'];

    public function Genre()
    {
        return $this->belongsTo(Genre::class, 'idgenre');
    }
    public function TypePersonnel()
    {
        return $this->belongsTo(TypePersonnel::class, 'idtypepersonnel');
    }
    public function Departement()
    {
        return $this->belongsTo(Departement::class, 'iddepartement');
    }
}