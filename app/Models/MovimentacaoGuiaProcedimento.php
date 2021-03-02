<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MovimentacaoGuiaProcedimento extends Model
{
    protected $table = 'movimentacao_guia_procedimentos';

    /**
     * The attributes that are mass assignable.
     * 
     * @var array
     */
    protected $fillable = [
        'valor', 'quantidade', 'valor_total', 'situacao', 'alterado', 'profissional_id', 'movimentacao_guia_id', 'valor_repasse', 'procedimento_id', 'observacao'
    ];

    /* Soft Deletes */
    use SoftDeletes;
    
    protected $dates = ['deleted_at'];
}
