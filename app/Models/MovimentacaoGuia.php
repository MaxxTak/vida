<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MovimentacaoGuia extends Model
{
    protected $table = 'movimentacoes_guias';

    /**
     * The attributes that are mass assignable.
     * 
     * @var array
     */
    protected $fillable = [
        'profissional_id', 'paciente_id', 'usuario_cadastro', 'situacao', 'valor_total', 'valor_repasse', 'plano_tipo'
    ];

    /* Soft Deletes */
    use SoftDeletes;
    
    protected $dates = ['deleted_at'];
}
