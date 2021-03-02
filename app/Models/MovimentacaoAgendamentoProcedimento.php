<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MovimentacaoAgendamentoProcedimento extends Model
{
    protected $table = 'movimentacao_agendamento_procedimentos';

    /**
     * The attributes that are mass assignable.
     * 
     * @var array
     */
    protected $fillable = [
        'situacao', 'movimentacao_agendamento_id', 'movimentacao_guia_procedimento_id', 'usuario_cadastro'
    ];

    /* Soft Deletes */
    use SoftDeletes;
    
    protected $dates = ['deleted_at'];
}
