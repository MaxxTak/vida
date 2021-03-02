<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProntuarioPacienteCampos extends Model
{
    protected $table = 'prontuario_paciente_campos';

    protected $fillable = [
        'sequencial', 'campo', 'descricao', 'valor', 'prontuario_paciente_id', 
    ];
}
