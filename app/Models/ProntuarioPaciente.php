<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProntuarioPaciente extends Model
{
    protected $table = 'prontuario_pacientes';

    protected $fillable = [
        'paciente_id', 'profissional_id', 'prontuario_id', 
    ];
}
