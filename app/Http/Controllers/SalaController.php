<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sala;
use App\Models\Especialidade;
use App\Models\SalaEspecialidade;

class SalaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Retorna itens
        $items = Sala::select('salas.id', 'salas.descricao')
                    ->get();

        return view('salas.index', compact('items'));
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
        // $especialidades->prepend('Selecione uma especialidade', '');

        $sala_especialidades = [];

        return view('salas.create', compact('especialidades', 'sala_especialidades'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, Sala::rules());
        
        $sala_id = Sala::create($request->all());

        $especialidades = $request->get('especialidade_id');

        if(!empty($especialidades)){
            for($i = 0; $i < count($especialidades); $i++){
                $sala_procedimento = [];
    
                $sala_procedimento['especialidade_id'] = $especialidades[$i];
                $sala_procedimento['sala_id'] = $sala_id['id'];
    
                SalaEspecialidade::create($sala_procedimento);
            }
        }

        return redirect()->route(VIDA . '.salas.index')->withSuccess(trans('app.success_store'));
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
        $item = Sala::findOrFail($id);

        // Popula lista com todas as salas e um em branco
        $especialidades = Especialidade::orderBy('id', 'asc')->get();
        $especialidades = $especialidades->pluck('titulo', 'id');
        // $especialidades->prepend('Selecione uma especialidade', '');

        // Pega especialidades da sala
        $sala_especialidades = SalaEspecialidade::where('sala_id', $id);
        $sala_especialidades = $sala_especialidades->pluck('id');
        
        return view('salas.edit', compact('item', 'especialidades', 'sala_especialidades'));
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
        $this->validate($request, Sala::rules());
        
        $item = Sala::findOrFail($id);

        // Verifica alteração DESCRIÇÃO
        if(($item->descricao != $request->get('descricao')) && !empty($request->get('descricao')))
            $item->descricao = $request->get('descricao');

        // Apaga especialidades da sala
        SalaEspecialidade::where('sala_id', $id)->delete();
        
        // Recria especialidades da sala
        $especialidades = $request->get('especialidade_id');

        if(!empty($especialidades)){
            for($i = 0; $i < count($especialidades); $i++){
                $sala_procedimento = [];
    
                $sala_procedimento['especialidade_id'] = $especialidades[$i];
                $sala_procedimento['sala_id'] = $id;
    
                SalaEspecialidade::create($sala_procedimento);
            }
        }
        
        // Salva alterações
        $item->save();

        return redirect()->route(VIDA . '.salas.index')->withSuccess(trans('app.success_update'));
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
