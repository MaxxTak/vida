<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SalaEspecialidade extends Model
{
    protected $table = 'sala_especialidades';

    protected $fillable = [
        'sala_id', 'especialidade_id'
    ];
    
}
