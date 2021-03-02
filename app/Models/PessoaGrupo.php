<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PessoaGrupo extends Model
{
    //
    protected $table = 'pessoa_grupo';
    protected $fillable = [
        'grupo_id',
        'user_id'
    ];
}
