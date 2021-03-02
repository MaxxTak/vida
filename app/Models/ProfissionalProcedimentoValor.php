<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProfissionalProcedimentoValor extends Model
{
    protected $table = 'profissional_procedimento_valores';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'valor', 'valor_particular', 'valor_repasse', 'percentual_repasse', 'profissional_proc_id', 'usuario_cadastro'
    ];
}
