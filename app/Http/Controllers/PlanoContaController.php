<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Plano_Conta;
use App\Models\Plano_Contas_Acessorios;

class PlanoContaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $items = Plano_Conta::latest('updated_at')->get();

        // Adiciona espaços para facilitar análise de hierarquia, de acordo com nível
        foreach($items as $item){
            $nivel = count(explode('.', $item->classificacao));

            $espacamento = str_repeat('&nbsp;&nbsp;', $nivel);

            $item->descricao = $espacamento . $item->descricao;
        }

        return view('plano_contas.index', compact('items'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('plano_contas.create');        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, Plano_Conta::rules());
        
        $plano = Plano_Conta::create($request->all());    

        return redirect()->route(VIDA . '.plano_contas.index')->withSuccess(trans('app.success_store'));
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
        // Select Plano Conta e Valores acessórios
        $item = Plano_Conta::select('plano_contas.id', 'plano_contas.descricao', 'plano_contas.classificacao', 'plano_contas.tipo', 
                                    'plano_contas_acessorios.juros', 'plano_contas_acessorios.multa', 'plano_contas_acessorios.mora', 'plano_contas_acessorios.desconto')
                            ->where('plano_contas.id', '=', $id)
                            ->leftJoin('plano_contas_acessorios', 'plano_contas.id', '=', 'plano_contas_acessorios.plano_contas_id')
                            ->first();

        // Formata valores para exibir corretamente
            $item->juros = number_format($item->juros, 2);
            $item->multa = number_format($item->multa, 2);
            $item->mora = number_format($item->mora, 2);
            $item->desconto = number_format($item->desconto, 2);

        return view('plano_contas.edit', compact('item'));
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
        //$this->validate($request, Plano_Conta::rules(true, $id));

        $item = Plano_Conta::findOrFail($id);

        $acessorios = Plano_Contas_Acessorios::where('plano_contas_id', '=', $id)->first();

        if(empty($acessorios)){
            $acessorios = new Plano_Contas_Acessorios([
                'plano_contas_id' => $id
            ]);
        }

        //Verifica alteração DESCRIÇÃO
        if(($item->descricao != $request->get('descricao')) && !empty($request->get('descricao')))
            $item->descricao = $request->get('descricao');

        //Formata JUROS
        if(empty($request->get('juros')))
            $request['juros'] = 0;
        else
            $request['juros'] = str_replace(',', '.', str_replace('.', '', $request->get('juros')));
        
        //Verifica alteração JUROS
        if($acessorios->juros != $request->get('juros'))
            $acessorios->juros = $request->get('juros');


        //Formata MULTA
        if(empty($request->get('multa')))
            $request['multa'] = 0;
        else
            $request['multa'] = str_replace(',', '.', str_replace('.', '', $request->get('multa')));

        //Verifica alteração MULTA
        if($acessorios->multa != $request->get('multa'))
            $acessorios->multa = $request->get('multa');
            

        //Formata MORA
        if(empty($request->get('mora')))
            $request['mora'] = 0;
        else
            $request['mora'] = str_replace(',', '.', str_replace('.', '', $request->get('mora')));

        //Verifica alteração MORA
        if($acessorios->mora != $request->get('mora'))
            $acessorios->mora = $request->get('mora');


        //Formata DESCONTO
        if(empty($request->get('desconto')))
            $request['desconto'] = 0;
        else
            $request['desconto'] = str_replace(',', '.', str_replace('.', '', $request->get('desconto')));

        //Verifica alteração DESCONTO
        if($acessorios->desconto != $request->get('desconto'))
            $acessorios->desconto = $request->get('desconto');

        $item->save();
        $acessorios->save();

        return redirect()->route(VIDA . '.plano_contas.index')->withSuccess(trans('app.success_update'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Plano_Conta::destroy($id);

        return back()->withSuccess(trans('app.success_destroy')); 
    }
}
