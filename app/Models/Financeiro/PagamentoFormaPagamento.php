<?php

namespace App\Models\Financeiro;

use Illuminate\Database\Eloquent\Model;

class PagamentoFormaPagamento extends Model
{
    /**
     * The connection name for the model.
     *
     * @var string
     */
 //   protected $connection = 'company';
    // Explicit table name example
    protected $table = 'pagamento_forma_pagamento';

    protected $fillable =[
        'forma_pagamento_id',
        'pagamento_id'
    ];

    public function pagamento()
    {
        return $this->belongsTo(\App\Model\Pagamento::class,'pagamento_id');
    }

    public function formaPagamento()
    {
        return $this->belongsTo(\App\Model\FormaPagamento::class,'forma_pagamento_id');
    }
}
