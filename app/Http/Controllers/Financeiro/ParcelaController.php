<?php

namespace App\Http\Controllers\Financeiro;

use App\Models\Financeiro\Movimentacao;
use App\Models\Financeiro\Pagamento;
use App\Models\Financeiro\Parcela;
use App\Models\Financeiro\ParcelaPagamento;
use App\Repositorio\ParcelaRepositorio;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ParcelaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return Parcela::all();
    }

    public function gerarParcelaRecorrente($request,$valor){
        $mov = $request->fk_movimentacao;
        $parcela = new Parcela([
            'movimentacao_id' => $mov,
            'valor' => $valor,
            'taxa' => 0,
            'data_vencimento' => Carbon::now()->addDay(),
            'status' => Parcela::STATUS_ID[Parcela::ABERTA]
        ]);

        $parcela->save();
        return $parcela;

    }

    public function gerarParcelaProduto($request,Movimentacao $movimentacao){

        $v=[];
        foreach ($request->parcelas as $key=>$parcela){

            $v[$key]=$this->gerarParcelaDebito($movimentacao, $parcela['valor'], $parcela['vencimento'], $parcela['forma_pagamento'],$parcela['taxa']);
        }


        return $v;
    }

    public function gerarParcelaDebito(Movimentacao $mov,$valor,$parcela_vencimento=null,$fpg = null, $taxa =0){
        $p_r = new ParcelaRepositorio();

        $retorno = $p_r->criarParcelaDebito($mov,$valor,$parcela_vencimento,$fpg, $taxa);
        return $retorno;
    }


    public function pagarParcela($parcelas,$valor, $pagamento, $servico = null){
        $total =0;
        $total_bd = 0;
        $mov = null;
        foreach ($parcelas as $parcela){
            $parcela_aux = Parcela::find($parcela['codigo']);
            $mov = $parcela_aux->movimentacao_id;
            $total_bd +=(float) $parcela_aux->valor;
            $total +=(float) $parcela['valor'];
        }
        $repo = new ParcelaRepositorio();
        if(($total_bd == $total) && ($total_bd <= $valor)){
            $resposta = $repo->quitarParcelas($parcelas,$pagamento);

            $cc = new ContaCorrenteController();
            $cc_resposta = $cc->gerarCredito($valor,$pagamento,$servico);

        }else{
            $resposta = $repo->descontarValorParcial($parcelas,$valor,$pagamento);
            $cc = new ContaCorrenteController();
            $cc_resposta = $cc->gerarCredito($valor,$pagamento,$servico);
        }

        $parcelas = Parcela::where('movimentacao_id',$mov)->get();

        $movimentacao  = Movimentacao::find($mov);
        $flag = 0;
        foreach ($parcelas as $parcela){
            if($parcela->status == Parcela::STATUS_ID[Parcela::ABERTA]){
                $movimentacao->status = Movimentacao::STATUS_ID[Movimentacao::PARCIALMENTE_PAGA];
                $movimentacao->save();
                return $resposta;
            }
        }
        $movimentacao->status = Movimentacao::STATUS_ID[Movimentacao::QUITADA];
        $movimentacao->save();
        return $resposta;

    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request,$id)
    {
        //
        $parcela = Parcela::find($id);
        $retorno =  collect($parcela);
        return $retorno;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id){

    }

    public function abrirStatus(Request $request, $id){
        $parcela = Parcela::find($id);
        $parcela->status = Parcela::STATUS_ID[Parcela::ABERTA];
        $parcela->save();
        $movimentacao = Movimentacao::find($parcela->movimentacao_id);
        $movimentacao->status = Movimentacao::STATUS_ID[Movimentacao::ABERTA];
        $movimentacao->save();

        return $parcela;
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $data = $request->get('data');

        $parcela = Parcela::find($id);


        $parcela->fk_forma_pagamento = $data['forma_pagamento'];
        $parcela->data_vencimento = $data['data'];
        $parcela->save();

        $retorno = collect($parcela);

        return $retorno;

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
