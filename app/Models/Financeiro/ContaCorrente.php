<?php

namespace App\Models\Financeiro;

use Illuminate\Database\Eloquent\Model;

class ContaCorrente extends Model
{
    /**
     * The connection name for the model.
     *
     * @var string
     */
   // protected $connection = 'company';
    // Explicit table name example
    protected $table = 'contas_corrente';

    protected $fillable =[
        'pessoa_id',
        'descricao',
        'saldo',
        'valor_servicos'
    ];

    public function pessoa()
    {
        return $this->belongsTo(\App\Models\Financeiro\Pessoa::class);
    }

    public function movimentacao()
    {
        return $this->relations['pessoa.movimentacao'];
    }

}
