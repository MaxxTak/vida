<?php

namespace App\Http\Controllers\Financeiro;

use App\Models\Financeiro\ContaCorrente;
use App\Models\Financeiro\Movimentacao;
use App\Models\Financeiro\Pagamento;
use App\Models\Financeiro\Pessoa;
use Illuminate\Http\Request;

class ContaCorrenteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return $cc = ContaCorrente::all();
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

    public function gerarDebito(Movimentacao $movimentacao,$valor,$servico=null){
        $cc = ContaCorrente::where('pessoa_id', $movimentacao->pessoa_id)->first();
        if(is_null($servico))
            $cc->saldo -= $valor;
        else
            $cc->valor_servicos -= $valor;

        $cc->save();
        return $cc;
    }
    public function gerarCredito($valor, $pagamento=null, $servico=null,$flag=0,$mov=null){
        if($flag==0){
            $p = Pagamento::where('id',$pagamento->id)->with('movimentacao')->get();
            $cc = ContaCorrente::where('pessoa_id',$p[0]->movimentacao->pessoa_id)->first();
        }
        else{
            $cc= ContaCorrente::where('pessoa_id','=',$mov->pessoa_id)->first();
        }


        if(is_null($servico))
            $cc->saldo +=$valor;
        else
            $cc->valor_servicos +=$valor;
        $cc->save();

        return $cc;
    }

    public function gerarCreditoEstorno($valor,Movimentacao $movimentacao, $servico=null){
        $cc = ContaCorrente::where('pessoa_id',$movimentacao->pessoa_id)->first();
        if(is_null($servico))
            $cc->saldo +=$valor;
        else
            $cc->valor_servicos +=$valor;
        $cc->save();

        return $cc;
    }


    public function criarContaCorrente($pessoa){
        $conta_corrente = new ContaCorrente([
            'pessoa_id'=>$pessoa->id,
            'descricao'=>"Conta Corrente",
            'saldo'=>0,
            'valor_servicos'=>0
        ]);
        $conta_corrente->save();
        return $conta_corrente;
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
    public function show($id)
    {
        //
        return $cc= ContaCorrente::find($id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
