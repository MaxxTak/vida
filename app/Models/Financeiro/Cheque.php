<?php

namespace App\Models\Financeiro;

use Illuminate\Database\Eloquent\Model;

class Cheque extends Model
{
    //
    protected $fillable =[
        'nome',
        'documento',
        'comp' ,
        'banco',
        'cooperativa',
        'conta',
        'numero',
        'valor',
        'data'
    ];
}
