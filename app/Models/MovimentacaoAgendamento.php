<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MovimentacaoAgendamento extends Model
{
    protected $table = 'movimentacoes_agendamentos';

    /**
     * The attributes that are mass assignable.
     * 
     * @var array
     */
    protected $fillable = [
        'situacao', 'start', 'end', 'allDay', 'movimentacao_guia_id', 'profissional_id', 'paciente_id', 'sala_id', 'usuario_cadastro', 'observacao'
    ];

    /* Soft Deletes */
    use SoftDeletes;
    
    protected $dates = ['deleted_at'];
}
