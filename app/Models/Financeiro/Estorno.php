<?php

namespace App\Models\Financeiro;

use Illuminate\Database\Eloquent\Model;

class Estorno extends Model
{
    //
    /**
     * The connection name for the model.
     *
     * @var string
     */
  //  protected $connection = 'company';
    protected $fillable =[
        'pagamentos_id',//fk que estornou
        'movimentacao_id',//fk para estornada (sempre gera movimentacao)
        'motivo_estorno',
        'pessoa_id',
        'valor',
        'data_estorno'
    ];

    public function movimentacao()
    {
        return $this->belongsTo(\App\Model\Movimentacao::class,'movimentacao_id_estornada');
    }
    public function pagamento()
    {
        return $this->belongsTo(\App\Model\Pagamento::class,'pagamento_id');
    }

}
