<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProntuarioCampo extends Model
{
    protected $table = 'prontuario_campos';

    protected $fillable = [
        'prontuario_id', 'sequencial', 'campo', 'descricao', 
    ];
}
