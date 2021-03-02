<?php

namespace App\Http\Controllers\Financeiro;

use App\Models\Formas_Pagamento as FormaPagamento;
use App\Models\Financeiro\Pagamento;
use App\Models\Financeiro\PagamentoFormaPagamento;
use Illuminate\Http\Request;

class FormaPagamentoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $fpg = FormaPagamento::all();

        return $fpg;
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


    public function gerarFormaCredito($request,$pagamento){
        $pgt_fpgt = new PagamentoFormaPagamento([
            'forma_pagamento_id'=>$request->forma_pagamento,
            'pagamento_id' => $pagamento->id
        ]);
        $pgt_fpgt->save();
    }

    public function gerarFormaPagamento($pagamento,$parcelas)
    {
        foreach ($parcelas as $key=>$parcela)
        {

            $pgt_fpgt = new PagamentoFormaPagamento([
                'forma_pagamento_id'=>$parcela['forma_pagamento'],
                'pagamento_id' => $pagamento->id
            ]);
            $pgt_fpgt->save();
        }

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $fpg = new FormaPagamento([
            'abatimento' => $request->get('quita'),
            'acrescimo' => $request->get('quita'),
            'descricao' => $request->get('descricao'),
        ]);
        $fpg->save();

        $fpg->tipo = $request->get('tipo');
        $fpg->taxa = $request->get('taxa');

        $fpg->save();

        return $fpg;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return FormaPagamento::find($id);
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
        $fpg = FormaPagamento::find($id);

        $fpg->descricao = $request->get('descricao');
        $fpg->tipo = $request->get('tipo');
        $fpg->taxa = $request->get('taxa');

        $fpg->save();

        return $fpg;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $fpg = FormaPagamento::find($id);
        $fpg->delete();
    }
}
