<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Aviso extends Model
{
    //

    protected $fillable =[
        'titulo',
        'conteudo',
        'data_validade',
        'pessoa_tipo',
        'user_id',
    ];

    public function user()
    {
        return $this->belongsTo(\App\User::class, 'user_id','id');
    }
}
