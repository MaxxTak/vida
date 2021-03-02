<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Endereco extends Model
{
    //


    protected $fillable =[
        'cep',
        'numero',
        'endereco',
        'complemento',
        'bairro',
        'cidade',
        'uf',
    ];
}
