<?php

namespace App\Models\Financeiro;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Movimentacao extends Model
{
    use SoftDeletes;
    /**
     * The connection name for the model.
     *
     * @var string
     */
 //   protected $connection = 'company';
    // Explicit table name example
    protected $table = 'movimentacoes';

    const ABERTA = 'Aberta';
    const QUITADA= 'Quitada';
    const ESTORNADA = 'Estornada';
    const CANCELADA = 'Cancelada';
    const ATRASADA = 'Atrasada';
    const PARCIALMENTE_PAGA = 'Parcialmente Paga';



    const STATUS = [
        1 => self::ABERTA,
        2 => self::QUITADA,
        3 => self::ESTORNADA,
        4 => self::CANCELADA,
        5 => self::ATRASADA,
        6 => self::PARCIALMENTE_PAGA
    ];

    const STATUS_ID = [
        self::ABERTA => 1,
        self::QUITADA => 2,
        self::ESTORNADA => 3,
        self::CANCELADA => 4,
        self::ATRASADA => 5,
        self::PARCIALMENTE_PAGA => 6,

    ];


    protected $fillable =[
        'tipo_id',
        'pessoa_id',
        'descricao',
        'valor',
        'descontos',
        'status'
    ];

    public function pessoa()
    {
        return $this->belongsTo(\App\Models\Financeiro\Pessoa::class);
    }

    public function guia()
    {
        return $this->belongsTo(\App\Models\MovimentacaoGuia::class, 'movimentacao_guia_id','id');
    }

    public function movimentacao()
    {
        return $this->hasOne(\App\Models\Financeiro\Movimentacao::class, 'movimentacao_id','id');
    }

    public function plano()
    {
        return $this->belongsTo(\App\Models\Plano_Conta::class,'plano_contas_id','id');
    }

    public function parcelas()
    {
        return $this->hasMany(\App\Models\Financeiro\Parcela::class,'movimentacao_id','id');
    }

    public function tipo()
    {
        return $this->belongsTo(\App\Models\MovimentacaoTipo::class,'movimentacao_tipo_id','id');
    }

    public function pagamento()
    {
        return $this->hasOne(\App\Models\Financeiro\Pagamento::class, 'movimentacao_id','id');
    }
}
