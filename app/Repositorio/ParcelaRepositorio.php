<?php
/**
 * Created by PhpStorm.
 * User: Thiago Akira Kamida
 */
namespace App\Repositorio;

use App\Http\Controllers\Financeiro\ContaCorrenteController;
use App\Http\Controllers\Financeiro\EstornoController;
use App\Models\Financeiro\Estorno;
use App\Models\Financeiro\Movimentacao;
use App\Models\Financeiro\Pagamento;
use App\Models\Financeiro\Parcela;
use App\Models\Financeiro\ParcelaPagamento;
use Carbon\Carbon;

class ParcelaRepositorio {

    public function criarParcelaDebito(Movimentacao $movimentacao,$valor,$parcela_vencimento=null,$fpg=null, $taxa=0)
    {
        $new_parcela = new Parcela([
            'movimentacao_id' => $movimentacao->id,
            'valor' => $valor,
            'taxa' => $taxa,
            'data_vencimento' => (is_null($parcela_vencimento)) ? Carbon::now()->endOfMonth() : $parcela_vencimento,
            'status' => Parcela::STATUS_ID[Parcela::ABERTA]
        ]);
        $new_parcela->save();
        $new_parcela->fk_forma_pagamento = $fpg;
        $new_parcela->save();

        return $new_parcela;
    }

    public function quitarParcelas($parcelas, Pagamento $pagamento)
    {
        foreach ($parcelas as $p)
        {
            $par = Parcela::find($p['codigo']);

            $ppg = new ParcelaPagamento([
                'pagamentos_id' => $pagamento->id,
                'parcela_id' => $par->id,
            ]);

            $ppg->save();
            $par->status = Parcela::STATUS_ID[Parcela::PAGA];
            $par->pagamento_id = $pagamento->id;
            $par->save();
        }

        return 1;
    }

    public function pagarParcialParcela($diferenca, $parcela, Pagamento $pagamento)
    {
        $parcela_bd = Parcela::find($parcela['codigo'])->with('movimentacao');
        $resta = $parcela_bd->valor - $diferenca;
        $new_parcela = new Parcela([
            'movimentacao_id' => $parcela_bd->movimentacao->id,
            'valor' => $resta,
            'taxa' => $parcela_bd->taxa,
            'data_vencimento' => $parcela_bd->data_vencimento,
            'status' => Parcela::STATUS_ID[Parcela::ABERTA]
        ]);
        $new_parcela->save();

        $parcela_bd->status = Parcela::STATUS_ID[Parcela::PARCIALMENTE_PAGA];
        $parcela_bd->valor_parcial = $diferenca;
        $parcela_bd->pagamento_id = $pagamento->id;
        $parcela_bd->save();

        $new_parcela->parcela_mae_id = $parcela_bd->id;
        $new_parcela->save();

        return $new_parcela;
    }

    public function descontarValorParcial($parcelas, $valor, Pagamento $pagamento)
    {
        $total = 0;
        $total_aux = 0;

        foreach ($parcelas as $parcela)
        {
            $total_aux += (float) $parcela['valor'];
            if($total_aux <= $valor)
            {
                $total = $total_aux;
                $par = Parcela::find($parcela['codigo']);
                $par->status = Parcela::STATUS_ID[Parcela::PAGA];
                $par->pagamento_id = $pagamento->id;
                $par->save();
            } else
            {
                $resposta = $this->pagarParcialParcela($valor-$total, $parcela, $pagamento);
                break;
            }
        }

        return $resposta;
    }

    public function estornarParcela(Parcela $parcela, $m_e){
        if($parcela->status == Parcela::STATUS_ID[Parcela::PAGA]){
            $estorno = new EstornoController();
            $estorno->estornarParcelaPagamento($parcela,$m_e);
        }else if($parcela->status == Parcela::STATUS_ID[Parcela::PARCIALMENTE_PAGA]){
            $estorno = new EstornoController();
            $estorno->estornarParcelaPagamento($parcela,$m_e,1);
        }else{
            $cc = new ContaCorrenteController();
            $cc->gerarCredito($parcela->valor,null,null,1,$m_e);
        }

        $p = Parcela::find($parcela->id);
        $p->status = Parcela::STATUS_ID[Parcela::ESTORNADA];
        $p->save();
        return $p;
    }

}
