<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProfissionalProcedimento extends Model
{
    protected $table = 'profissional_procedimentos';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'procedimento_id', 'user_id', 'valor', 'valor_particular', 'valor_repasse', 'percentual_repasse', 'usuario_cadastro', 'tempo_atendimento'
    ];

}
