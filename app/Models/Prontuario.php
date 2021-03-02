<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Prontuario extends Model
{
    protected $table = 'prontuarios';

    protected $fillable = [
        'descricao', 'especialidade_id', 'usuario_cadastro', 
    ];
}
