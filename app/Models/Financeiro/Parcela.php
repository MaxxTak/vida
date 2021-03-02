<?php

namespace App\Models\Financeiro;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Parcela extends Model
{
    use SoftDeletes;
    /**
     * The connection name for the model.
     *
     * @var string
     */
  //  protected $connection = 'company';
    //
    const ABERTA = 'Aberta';
    const PAGA = 'Paga';
    const ESTORNADA = 'Estornada';
    const CANCELADA = 'Cancelada';
    const ATRASADA = 'Atrasada';
    const PARCIALMENTE_PAGA = 'Parcialmente Paga';



    const STATUS = [
        1 => self::ABERTA,
        2 => self::PAGA,
        3 => self::ESTORNADA,
        4 => self::CANCELADA,
        5 => self::ATRASADA,
        6 => self::PARCIALMENTE_PAGA
    ];

    const STATUS_ID = [
        self::ABERTA => 1,
        self::PAGA => 2,
        self::ESTORNADA => 3,
        self::CANCELADA => 4,
        self::ATRASADA => 5,
        self::PARCIALMENTE_PAGA => 6,

    ];


    protected $fillable =[
        'movimentacao_id',
        'valor',
        'taxa',
        'data_vencimento',
        'status'
    ];

    public function movimentacao()
    {
        return $this->belongsTo(\App\Models\Financeiro\Movimentacao::class,'movimentacao_id','id');
    }

    public function forma(){
        return $this->belongsTo(\App\Models\Formas_Pagamento::class,'fk_forma_pagamento','id');
    }

    public function parcelaPagamento()
    {
        return $this->hasMany(\App\Models\Financeiro\ParcelaPagamento::class);
    }
}
