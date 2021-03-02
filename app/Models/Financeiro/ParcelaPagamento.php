<?php

namespace App\Models\Financeiro;

use Illuminate\Database\Eloquent\Model;

class ParcelaPagamento extends Model
{
    /**
     * The connection name for the model.
     *
     * @var string
     */
 //   protected $connection = 'company';
    // Explicit table name example
    protected $table = 'parcela_pagamentos';

    protected $fillable =[
        'pagamentos_id',
        'parcela_id',
    ];

    public function parcela()
    {
        return $this->belongsTo(\App\Models\Financeiro\Parcela::class,'parcela_id');
    }

    public function pagamento()
    {
        return $this->belongsTo(\App\Models\Financeiro\Pagamento::class,'pagamento_id');
    }
}
