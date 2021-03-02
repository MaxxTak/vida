<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Paciente extends Model
{
    //
    protected $fillable=[
        'profissao',
        'data_nascimento',

    ];
}
