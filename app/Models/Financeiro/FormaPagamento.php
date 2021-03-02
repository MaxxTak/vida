<?php

namespace App\Models\Financeiro;

use Illuminate\Database\Eloquent\Model;

class FormaPagamento extends Model
{
    /**
     * The connection name for the model.
     *
     * @var string
     */
  //  protected $connection = 'company';

    // Explicit table name example
    protected $table = 'formas_pagamento';

    protected $fillable = [
        'descricao',
        'quita',
        'moeda_id',
        'taxa'
    ];

    public function pagamentos()
    {
        return $this->hasMany(\App\Model\PagamentoFormaPagamento::class,'forma_pagamento_id','id');
    }
}
