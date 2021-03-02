<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Profissional extends Model
{
    protected $table = 'profissionais';
    //
    protected $fillable=[
        'cargo',
        'registro',
        'data_nascimento',
        'observacao'

    ];
}
