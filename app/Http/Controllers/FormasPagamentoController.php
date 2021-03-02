<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Formas_Pagamento;

class FormasPagamentoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Retorna itens
        $items = Formas_Pagamento::latest('updated_at')->get();

        return view('formas_pagamento.index', compact('items'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('formas_pagamento.create');        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, Formas_Pagamento::rules());

        $req = collect($request);

        // Formata valores para exibir corretamente
        if(empty($req->get('acrescimo')))
            $req['acrescimo'] = 0;
        else
            $req['acrescimo'] = str_replace(',', '.', str_replace('.', '', $req->get('acrescimo')));

        // Formata valores para exibir corretamente
        if(empty($req->get('abatimento')))
            $req['abatimento'] = 0;
        else
            $req['abatimento'] = str_replace(',', '.', str_replace('.', '', $req->get('abatimento')));

        Formas_Pagamento::create($req->all());    

        return redirect()->route(VIDA . '.formas_pagamento.index')->withSuccess(trans('app.success_store'));
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
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $item = Formas_Pagamento::findOrFail($id);

        // Formata valores para exibir corretamente
        $item->acrescimo = number_format($item->acrescimo, 2);
        $item->abatimento = number_format($item->abatimento, 2);

        return view('formas_pagamento.edit', compact('item'));
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
        $item = Formas_Pagamento::findOrFail($id);

        // Formata valores numéricos para banco de dados
        if(empty($request->get('acrescimo')))
            $request['acrescimo'] = 0;
        else
            $request['acrescimo'] = str_replace(',', '.', str_replace('.', '', $request->get('acrescimo')));

        // Formata valores numéricos para banco de dados
        if(empty($request->get('abatimento')))
            $request['abatimento'] = 0;
        else
            $request['abatimento'] = str_replace(',', '.', str_replace('.', '', $request->get('abatimento')));

        // Verifica alteração DESCRIÇÃO
        if(($item->descricao != $request->get('descricao')))
            $item->descricao = $request->get('descricao');

        // Verifica alteração ACRÉSCIMO
        if(($item->acrescimo != $request->get('acrescimo')))
            $item->acrescimo = $request->get('acrescimo');

        // Verifica alteração ABATIMENTO
        if(($item->abatimento != $request->get('abatimento')))
            $item->abatimento = $request->get('abatimento');

        // Salva alterações
        $item->save();

        return redirect()->route(VIDA . '.formas_pagamento.index')->withSuccess(trans('app.success_update'));
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
