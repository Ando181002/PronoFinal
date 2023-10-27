<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Validation\Rule;


class TestLdap extends Model
{
    use HasFactory;

    public $timestamps=false;
    public $incrementing=false;
    protected $table = 'testldap';
    protected $primaryKey='uid';
    protected $fillable = ['uid','nom','email','mdp','datecreation','dateexpiration'];

  
}