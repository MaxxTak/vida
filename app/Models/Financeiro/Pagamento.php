<?php

namespace App\Models\Financeiro;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pagamento extends Model
{
    use SoftDeletes;
    /**
     * The connection name for the model.
     *
     * @var string
     */
  //  protected $connection = 'company';

    protected $fillable = [
        'valor',
        'data',
        'movimentacao_id',
        'taxa_cartao'
    ];

    public function movimentacao()
    {
        return $this->belongsTo(\App\Models\Financeiro\Movimentacao::class,'movimentacao_id','id');
    }

    public function parcelaPagamento()
    {
        return $this->hasMany(\App\Models\Financeiro\ParcelaPagamento::class,'pagamentos_id','id');
    }
}
