<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Procedimento;
use App\Models\Especialidade;
use Illuminate\Support\Facades\Auth;

class ProcedimentoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $items = Procedimento::select('procedimentos.*', 'especialidades.titulo as especialidade')
                    ->leftJoin('especialidades', 'procedimentos.especialidade_id', '=', 'especialidades.id')
                    ->get();

        return view('procedimentos.index', compact('items'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // Popula lista com todos planos de contas e um em branco
        $especialidades = Especialidade::orderBy('id', 'asc')->get();
        $especialidades = $especialidades->pluck('titulo', 'id');
        $especialidades->prepend('Selecione uma especialidade', '');

        return view('procedimentos.create', compact('especialidades'));
    }

     /**
     * Pega procedimentos
     *
     * @return \Illuminate\Http\Response
     */
    public function getProcedimento(Request $request)
    {
        $procedimento_id = $request->get('procedimento_id');

        $procedimento = Procedimento::findOrFail($procedimento_id);

        return response()->json(array(
            'status' => 'sucesso',
            'data' => $procedimento
        ), 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, Procedimento::rules());
        
        // Request para Array
        $req = collect($request);

        // Informa usuário de cadastro
        $req->put('usuario_cadastro', Auth::id());
        
        Procedimento::create($req->all());

        return redirect()->route(VIDA . '.procedimentos.index')->withSuccess(trans('app.success_store'));
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
        $item = Procedimento::findOrFail($id);

        // Popula lista com todos planos de contas e um em branco
        $especialidades = Especialidade::orderBy('id', 'asc')->get();
        $especialidades = $especialidades->pluck('titulo', 'id');
        $especialidades->prepend('Selecione uma especialidade', '');
        
        return view('procedimentos.edit', compact('item', 'especialidades'));
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
        $this->validate($request, Procedimento::rules());
        
        $item = Procedimento::findOrFail($id);

        // Verifica alteração DESCRIÇÃO
        if(($item->descricao != $request->get('descricao')) && !empty($request->get('descricao')))
            $item->descricao = $request->get('descricao');

        // Verifica alteração PREPARO
        if(($item->preparo != $request->get('preparo')) && !empty($request->get('preparo')))
            $item->preparo = $request->get('preparo');

        // Verifica alteração ESPECIALIDADE ID
        if(($item->especialidade_id != $request->get('especialidade_id')))
            $item->especialidade_id = $request->get('especialidade_id');

        // Salva alterações
        $item->save();

        return redirect()->route(VIDA . '.procedimentos.index')->withSuccess(trans('app.success_update'));
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
