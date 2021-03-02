<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Formas_Pagamento extends Model
{
    protected $table = 'formas_pagamento';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'descricao',
        'abatimento',
        'acrescimo',
     //   'tipo',   USA NO FINANCEIRO (COMENTADO PARA NÃO DAR ERRO EM OUTROS LUGARES)
     //   'taxa'   USA NO FINANCEIRO (COMENTADO PARA NÃO DAR ERRO EM OUTROS LUGARES)
    ];

    public static function rules($id = null)
    {
        $commun = [
            'descricao'             => "required|unique:formas_pagamento",
        ];

        return $commun;
    }

    /* Soft Deletes */
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    public function pagamentos()
    {
        return $this->hasMany(\App\Models\Financeiro\PagamentoFormaPagamento::class,'forma_pagamento_id','id');
    }
}
