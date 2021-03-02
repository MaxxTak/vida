<?php

namespace App\Models\Financeiro;

use Illuminate\Database\Eloquent\Model;

class MovimentacaoTipo extends Model
{
    /**
     * The connection name for the model.
     *
     * @var string
     */
    //protected $connection = 'company';
    //
    protected $table = 'movimentacao_tipos';

    protected $fillable=[
        'descricao',
        'tipo',
        'sentido'
    ];

    const PAGAMENTO = 'Pagamento';
    const CREDITO = 'Crédito';
    const DEBITO = 'Débito';
    const SERVICO = 'Servico';
    const ESTORNO = 'Estorno';
    const PRODUTO = 'Produto';
    const RECORRENTE = 'Recorrente';




    const TIPO = [
        1 => self::PAGAMENTO,
        2 => self::CREDITO,
        3 => self::DEBITO,
        4 => self::SERVICO,
        5 => self::ESTORNO,
        6 => self::PRODUTO,
        7 => self::RECORRENTE,
    ];

    const TIPO_ID = [
        self::PAGAMENTO => 1,
        self::CREDITO => 2,
        self::DEBITO => 3,
        self::SERVICO => 4,
        self::ESTORNO => 5,
        self::PRODUTO => 6,
        self::RECORRENTE => 7,

    ];



    public function movimentacao(){
        return $this->hasMany(\App\Model\Movimentacao::class);
    }
}
