<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Personnel extends Model
{
    use HasFactory;

    public $timestamps=false;
    protected $table = 'personnel';
    protected $primaryKey='trigramme';
    protected $fillable = ['nom','datenaissance','idgenre','email','mdp','telephone','idtypepersonnel','iddepartement'];

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