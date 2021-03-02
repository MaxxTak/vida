<?php

namespace App\Http\Controllers;

use App\Models\ProfissionalProcedimento;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\User;
use App\Models\Especialidade;
use App\Models\ProfissionalEspecialidade;
use App\Models\Procedimento;
use Illuminate\Support\Facades\Auth;
use App\Models\ProfissionalProcedimentoValor;

class ProfissionalProcedimentoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // Pega profissional do request
        $profissional_id = $request->get('profissional');
        
        // Pega profissional request
        $profissional = User::where('id', '=', $profissional_id)->get();        
        
        // Pega lista profissionais e/ou empresas
        $profissionais = User::where('profissional_id', '<>', null)
                            ->orWhere('empresa_id', '<>', null)
                            ->orderBy('name', 'asc')
                            ->get();
        $profissionais = $profissionais->pluck('name', 'id');
        $profissionais->prepend('Selecione um profissional', '');

        // Pega lista especialidades
        $especialidades = Especialidade::orderBy('descricao', 'asc')->get();
        $especialidades = $especialidades->pluck('descricao', 'id');
        $especialidades->prepend('Selecione uma especialidade', '');

        // Pega especialidades profissional
        $profissionalEspecialidades = ProfissionalEspecialidade::where('user_id', '=', $profissional_id)->get();

        $profissionalProcedimentos = ProfissionalProcedimento::where('user_id', '=', $profissional_id)->get();

        return view('profissional_procedimentos.index', compact('profissional', 'profissionais', 'especialidades', 'profissionalEspecialidades'));
    }

    /**
     * Histórico de Valores
     *
     * @return \Illuminate\Http\Response
     */
    public function historico($id)
    {
        $profissional_procedimento = ProfissionalProcedimento::select('profissional_procedimentos.*', 'users.name', 'procedimentos.descricao')
                                                            ->where('profissional_procedimentos.id', $id)
                                                            ->join('users', 'users.id', '=', 'profissional_procedimentos.user_id')
                                                            ->join('procedimentos', 'procedimentos.id', '=', 'profissional_procedimentos.procedimento_id')
                                                            ->get()
                                                            ->first();

        $items = ProfissionalProcedimentoValor::select('profissional_procedimento_valores.*', 'users.name')
                                            ->where('profissional_proc_id', '=', $id)
                                            ->join('users', 'users.id', '=', 'profissional_procedimento_valores.usuario_cadastro')
                                            ->orderBy('profissional_procedimento_valores.id', 'desc')
                                            ->get();

        return view('profissional_procedimentos.historico', compact('profissional_procedimento', 'items'));
    }

    /**
     * Pega procedimentos de especialidades
     *
     * @return \Illuminate\Http\Response
     */
    public function getProcedimentosEspecialidades(Request $request)
    {
        $especialidades_id = $request->get('especialidades_id');

        if(empty($especialidades_id[0])){
            $procedimentos = Procedimento::select('procedimentos.id', 'procedimentos.descricao', 'especialidades.titulo as especialidade')
                                        ->leftJoin('especialidades', 'procedimentos.especialidade_id', '=', 'especialidades.id')
                                        ->get();
        }else{
            $procedimentos = Procedimento::select('procedimentos.id', 'procedimentos.descricao', 'especialidades.titulo as especialidade')
                                        ->whereIn('especialidade_id', $especialidades_id)
                                        ->leftJoin('especialidades', 'procedimentos.especialidade_id', '=', 'especialidades.id')
                                        ->get();
        }

        return response()->json(array(
            'status' => 'sucesso',
            'data' => $procedimentos,
        ), 200);
    }

    /**
     * Pega especialidades profissional
     *
     * @return \Illuminate\Http\Response
     */
    public function getEspecialidadesProfissional(Request $request)
    {
        $profissional_id = $request->get('profissional_id');

        // Pega especialidades profissional
        $profissionalEspecialidades = ProfissionalEspecialidade::where('user_id', '=', $profissional_id)->get();

        return response()->json(array(
            'status' => 'sucesso',
            'data' => $profissionalEspecialidades
        ), 200);
    }

    /**
     * Pega procedimentos do profissional
     *
     * @return \Illuminate\Http\Response
     */
    public function getProcedimentosProfissional(Request $request)
    {
        $profissional_id = $request->get('profissional_id');

        // Verificar se paciente é particular ou plano
        $plano_tipo = $request->get('plano_tipo');

        $profissional_procedimentos = ProfissionalProcedimento::select('profissional_procedimentos.*', 'procedimentos.descricao as procedimento', 'especialidades.titulo as especialidade')
                                                            ->leftJoin('procedimentos', 'profissional_procedimentos.procedimento_id', '=', 'procedimentos.id')
                                                            ->leftJoin('especialidades', 'procedimentos.especialidade_id', '=', 'especialidades.id')
                                                            ->where('user_id', '=', $profissional_id)
                                                            ->get();
            
        // Atualiza valor para particular / plano
        for($i = 0; $i < count($profissional_procedimentos); $i++){
            $profissional_procedimento = $profissional_procedimentos[$i];

            // Se particular, utilizar valor particular
            if($plano_tipo == 'P')
                $profissional_procedimento['valor'] = $profissional_procedimento['valor_particular'];
        }

        return response()->json(array(
            'status' => 'sucesso',
            'data' => $profissional_procedimentos
        ), 200);
    }

    /**
     * Pega procedimento específico do profissional
     *
     * @return \Illuminate\Http\Response
     */
    public function getProcedimentoProfissional(Request $request)
    {
        $procedimento_id = $request->get('procedimento_id');
        $profissional_id = $request->get('profissional_id');

        // Pega informações atuais
        if($procedimento_id && $profissional_id)
            $profissional_procedimento = ProfissionalProcedimento::where('procedimento_id', $procedimento_id)
                                                                ->where('user_id', $profissional_id)
                                                                ->first();
        else
            $profissional_procedimento = [];
        
        return response()->json(array(
            'status' => 'sucesso',
            'data' => $profissional_procedimento
        ), 200);
    }

    /**
     * Atualiza procedimentos do profissional
     *
     * @return \Illuminate\Http\Response
     */
    public function atualizaProcedimentoProfissional(Request $request)
    {
        $procedimento_id = $request->get('procedimento_id');

        // Pega informações atuais
        $item = ProfissionalProcedimento::findOrFail($procedimento_id);

        // Collect Request
        $req = collect($request);
        $valorAlterado = false;

        // Verifica alteração VALOR
        if(($item->valor != $request->get('valor')) && !empty($request->get('valor'))){
            // Atualizar VALOR
            $item->valor = $request->get('valor');

            // Atualização de histórico de preço
            $valorAlterado = true;
            $req->put('usuario_cadastro', Auth::id());
            $req->put('profissional_proc_id', $procedimento_id);
        }

        // Verifica alteração VALOR PARTICULAR
        if(($item->valor_particular != $request->get('valor_particular')) && !empty($request->get('valor_particular'))){
            // Atualizar VALOR
            $item->valor_particular = $request->get('valor_particular');

            // Atualização de histórico de preço
            $valorAlterado = true;
            $req->put('usuario_cadastro', Auth::id());
            $req->put('profissional_proc_id', $procedimento_id);
        }

        // Verifica alteração VALOR REPASSE
        if(($item->valor_repasse != $request->get('valor_repasse'))){
            // Atualizar VALOR REPASSE
            if(empty($request->get('valor_repasse')))
                $item->valor_repasse = 0;
            else
                $item->valor_repasse = $request->get('valor_repasse');

            // Atualização de histórico de preço
            $valorAlterado = true;
            $req->put('usuario_cadastro', Auth::id());
            $req->put('profissional_proc_id', $procedimento_id);
        }

        // Verifica alteração PERCENTUAL REPASSE
        if(($item->percentual_repasse != $request->get('percentual_repasse'))){
            // Atualizar PERCENTUAL REPASSE
            if(empty($request->get('percentual_repasse')))
                $item->percentual_repasse = 0;
            else
                $item->percentual_repasse = $request->get('percentual_repasse');

            // Atualização de histórico de preço
            $valorAlterado = true;
            $req->put('usuario_cadastro', Auth::id());
            $req->put('profissional_proc_id', $procedimento_id);
        }

        // Verifica alteração TEMPO ATENDIMENTO
        if(($item->tempo_atendimento != $request->get('tempo_atendimento'))){
            // Atualizar PERCENTUAL REPASSE
            if(empty($request->get('tempo_atendimento')))
                $item->tempo_atendimento = 0;
            else
                $item->tempo_atendimento = $request->get('tempo_atendimento');
        }

        // Grava histórico de alteração, se houver
        if($valorAlterado)
            ProfissionalProcedimentoValor::create($req->all());

        $item->save();

        return response()->json(array(
            'status' => 'sucesso',
        ), 200);
    }

    /**
     * Insere procedimento para o profissional
     *
     * @return \Illuminate\Http\Response
     */
    public function adicionaProcedimentoProfissional(Request $request)
    {   
        // Request para Array
        $req = collect($request);

        // Informa usuário de cadastro
        $req->put('usuario_cadastro', Auth::id());

        if(empty($req->get('valor')))
            $req['valor'] = 0;
        if(empty($req->get('valor_particular')))
            $req['valor_particular'] = 0;
        if(empty($req->get('valor_repasse')))
            $req['valor_repasse'] = 0;

        if(empty($req->get('percentual_repasse')))
            $req['percentual_repasse'] = 0;
        if(empty($req->get('tempo_atendimento')))
            $req['tempo_atendimento'] = 0;
        // Efetua cadastro
        $plano = ProfissionalProcedimento::create($req->all());    

        return response()->json(array(
            'status' => 'sucesso',
        ), 200);
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
     * @param  \App\Models\ProfissionalProcedimento  $profissionalProcedimento
     * @return \Illuminate\Http\Response
     */
    public function show(ProfissionalProcedimento $profissionalProcedimento)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ProfissionalProcedimento  $profissionalProcedimento
     * @return \Illuminate\Http\Response
     */
    public function edit(ProfissionalProcedimento $profissionalProcedimento)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ProfissionalProcedimento  $profissionalProcedimento
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ProfissionalProcedimento $profissionalProcedimento)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ProfissionalProcedimento  $profissionalProcedimento
     * @return \Illuminate\Http\Response
     */
    public function destroy(ProfissionalProcedimento $profissionalProcedimento)
    {
        //
    }
}
