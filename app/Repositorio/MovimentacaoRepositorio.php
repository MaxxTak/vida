<?php
/**
 * Created by PhpStorm.
 * User: Thiago Akira Kamida
 */

namespace App\Repositorio;


use App\Exceptions\NoContentException;
use App\Http\Controllers\Financeiro\ContaCorrenteController;
use App\Http\Controllers\Financeiro\EstornoController;
use App\Http\Controllers\Financeiro\PagamentoController;
use App\Http\Controllers\Financeiro\ParcelaController;
use App\Http\Controllers\Financeiro\PessoaController;
use App\Models\Financeiro\Movimentacao;
use App\Models\Financeiro\MovimentacaoTipo;
use App\Models\Financeiro\Parcela;
use App\Models\Financeiro\Pessoa;
use App\User;
use Illuminate\Http\Response;

class MovimentacaoRepositorio
{

    public function gerarMovimentacao($request,$tipo){
        $sentido=null;
        if(isset($request->movimentacao_sentido))
            $sentido = $request->movimentacao_sentido;

        $cod_ext = (int)$request->user_id;

        $parcela_vencimento =null;
        if(isset($request->parcela_vencimento))
            $parcela_vencimento = $request->parcela_vencimento;

        $mov_tipo = MovimentacaoTipo::where('tipo',$tipo)->first();

        $pessoa = Pessoa::where('codigo_externo',$cod_ext)->first();

        if(is_null($pessoa)){
            $p_c = new PessoaController();
            $pessoa = $p_c->criarPessoa($cod_ext);
        }


        $desconto = isset($request->desconto)? (float)$request->desconto : 0;

        $taxa_cartao = isset($request->taxa_cartao)? (float)$request->taxa_cartao : 0; //ver isso

        $valor =(float) $request->valor;
        $valor_total = $valor - $desconto;
        if(is_null($mov_tipo)){
            abort(403, 'movimentacao_tipo não encontrada.');
        }

        $mov = new Movimentacao([
            'tipo_id'=>$mov_tipo->id,
            'pessoa_id'=>$pessoa->id,
            'descricao'=>$request->descricao,
            'valor'=>$valor,
            'descontos'=> $desconto,
            'status'=> Movimentacao::STATUS_ID[Movimentacao::ABERTA]
        ]);
        $mov->save();
        $mov->valor_total = number_format($valor_total, 2, '.', '');

        $mov->sentido = !is_null($sentido) ? $sentido : null;
        $mov->save();

        if(isset($request->guia_id)){
            $mov->movimentacao_guia_id = $request->guia_id;
            $mov->save();
        }

        if($sentido == 'C'){
            switch ($tipo) {
                case MovimentacaoTipo::TIPO_ID[MovimentacaoTipo::PAGAMENTO]:{
                    $pagamento = new PagamentoController();
                    $retorno = $pagamento->gerarPagamentoParcelas($request,$mov);
                    break;
                }
                case MovimentacaoTipo::TIPO_ID[MovimentacaoTipo::CREDITO]:{
                    //$pagamento = PagamentoController::pagamentoCredito($request, $valor_total, $taxa_cartao, $mov);

                    $conta = new ContaCorrenteController();
                    $retorno = $conta->gerarCredito($valor_total,null,null, 1, $mov);
                    break;
                }
                case MovimentacaoTipo::TIPO_ID[MovimentacaoTipo::SERVICO]:{
                    $pagamento = new PagamentoController();
                    $retorno = $pagamento->gerarPagamentoParcelas($request,$mov, 1);
                    break;
                }
            }
        }else if($sentido == 'D'){
            switch ($tipo){
                case MovimentacaoTipo::TIPO_ID[MovimentacaoTipo::DEBITO]:{
//                    $p_c = new ParcelaController();
//                    $parcela = $p_c->gerarParcelaDebito($mov,$valor,$parcela_vencimento,$request->forma_pagamento);
                    $conta = new ContaCorrenteController();
                    $retorno = $conta->gerarDebito($mov,$valor);
                    break;
                }
                case MovimentacaoTipo::TIPO_ID[MovimentacaoTipo::SERVICO]:{
                    $parcela = new ParcelaController();
                    $parcela_d = $parcela->gerarParcelaDebito($mov,$valor,$parcela_vencimento, $fpg =0);
                    $conta = new ContaCorrenteController();
                    $retorno = $conta->gerarDebito($mov,$valor_total,1);
                    break;
                }
                case MovimentacaoTipo::TIPO_ID[MovimentacaoTipo::PRODUTO]:{

                    $parcela = new ParcelaController();
                    $retorno = $parcela->gerarParcelaProduto($request,$mov);
                 //   $conta = new ContaCorrenteController();
                 //   $retorno = $conta->gerarDebito($mov,$valor_total);
                    break;
                }
                case MovimentacaoTipo::TIPO_ID[MovimentacaoTipo::RECORRENTE]:{
                    $parcela = new ParcelaController();
                    $retorno =  $parcela->gerarParcelaProduto($request,$mov);
                    //$conta = new ContaCorrenteController();
                   // $retorno = $conta->gerarDebito($mov,$valor, 1);
                    break;
                }
            }
        }else{
            switch ($tipo){
                case MovimentacaoTipo::TIPO_ID[MovimentacaoTipo::ESTORNO]:{

                    $estorno = new EstornoController();
                    $retorno = $estorno->estornarMovimentacao($request,$mov, $pessoa);
                    break;
                }
                case MovimentacaoTipo::TIPO_ID[MovimentacaoTipo::PAGAMENTO]:{

                    $estorno = new EstornoController();
                    $retorno = $estorno->estornarPagamento($request,$mov);
                    //return $retorno;
                    break;
                }
                case MovimentacaoTipo::TIPO_ID[MovimentacaoTipo::SERVICO]:{
                    $estorno = new EstornoController();
                    $retorno = $estorno->estornarMovimentacao($request,$mov,$pessoa);
                    break;
                }
            }

        }

        return $mov;
    }

    public function estornarMovimentacao($movimentacao, $m_e){
        $movimentacao->status = Movimentacao::STATUS_ID[Movimentacao::ESTORNADA];
        $movimentacao->save();

        $p_c = new ParcelaRepositorio();

        $parcelas = Parcela::where('movimentacao_id',$movimentacao->id)->get();
        $parcelas_aux=[];
        foreach($parcelas as $key=>$parcela){
            $parcelas_aux[$key]=$p_c->estornarParcela($parcela,$m_e);
        }

        return $parcelas_aux;

    }
}
