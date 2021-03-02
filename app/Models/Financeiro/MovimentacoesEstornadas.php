<?php

namespace App\Models\Financeiro;

use Illuminate\Database\Eloquent\Model;

class MovimentacoesEstornadas extends Model
{
    /**
     * The connection name for the model.
     *
     * @var string
     */
 //   protected $connection = 'company';
    //
    protected $table = 'movimentacoes_estornadas';

    protected $fillable =[
        'movimentacao_id',//fk que estornou
        'movimentacao_id_estornada',//fk para estornada
        'motivo_estorno',
        'pessoa_id',
        'sentido_cc',
        'num_parcelas',
        'data_estorno'
    ];

    public function pessoa()
    {
        return $this->belongsTo(\App\Model\Pessoa::class);
    }
}
