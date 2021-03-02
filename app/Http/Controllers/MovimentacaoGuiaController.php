<?php

namespace App\Http\Controllers;

use App\Models\MovimentacaoGuia;
use Illuminate\Http\Request;
use App\User;
use App\Models\Especialidade;
use Illuminate\Support\Facades\Auth;
use App\Models\MovimentacaoGuiaProcedimento;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class MovimentacaoGuiaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // Pega lista pacientes
        // $pacientes = User::select(DB::raw("CONCAT(nim, '  ', name) AS name"), 'id')
        //                             ->where('paciente_id', '<>', null)
        //                             ->orderBy('name', 'asc')
        //                             ->get();

        $pacientes = DB::table('users as u')
                    ->select("u.id AS id", \DB::raw("(CASE WHEN u.titular_id IS NULL THEN CONCAT(COALESCE(u.nim, ''), '  ', COALESCE(u.name, '')) ELSE CONCAT(COALESCE(t.nim, ''), '.', COALESCE(u.ordem, ''), '  ', COALESCE(u.name, '')) END) AS name"))
                    ->leftJoin('users AS t', 'u.titular_id', '=', 't.id')
                    ->where('u.paciente_id', '<>', null)
                    ->orderBy('u.name', 'ASC')
                    ->get();

        $pacientes = $pacientes->pluck('name', 'id');
        $pacientes->prepend('Selecione um paciente', '');

        // Pega lista profissionais e/ou empresas
        $profissionais = User::where('profissional_id', '<>', null)
                            ->orWhere('empresa_id', '<>', null)
                            ->orderBy('name', 'asc')
                            ->get();
        $profissionais = $profissionais->pluck('name', 'id');
        $profissionais->prepend('Selecione um profissional', '');

        return view('guias.index', compact('pacientes', 'profissionais'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function consultar(Request $request)
    {
        // Pega lista pacientes
        // $pacientes = User::select(DB::raw("CONCAT(nim, '  ', name) AS name"), 'id')
        //                             ->where('paciente_id', '<>', null)
        //                             ->orderBy('name', 'asc')
        //                             ->get();

        $pacientes = DB::table('users as u')
                    ->select("u.id AS id", \DB::raw("(CASE WHEN u.titular_id IS NULL THEN CONCAT(COALESCE(u.nim, ''), '  ', COALESCE(u.name, '')) ELSE CONCAT(COALESCE(t.nim, ''), '.', COALESCE(u.ordem, ''), '  ', COALESCE(u.name, '')) END) AS name"))
                    ->leftJoin('users AS t', 'u.titular_id', '=', 't.id')
                    ->where('u.paciente_id', '<>', null)
                    ->orderBy('u.name', 'ASC')
                    ->get();
                    
        $pacientes = $pacientes->pluck('name', 'id');
        $pacientes->prepend('Selecione um paciente', '');

        // Pega lista profissionais e/ou empresas
        $profissionais = User::where('profissional_id', '<>', null)
                            ->orWhere('empresa_id', '<>', null)
                            ->orderBy('name', 'asc')
                            ->get();
        $profissionais = $profissionais->pluck('name', 'id');
        $profissionais->prepend('Selecione um profissional', '');

        return view('guias.consultar', compact('pacientes', 'profissionais'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function imprimir(Request $request)
    {
        return view('guias.imprimir');
    }
    
     /**
     * Pega guias
     *
     * @return \Illuminate\Http\Response
     */
    public function getGuias(Request $request)
    {
        $profissional_id = $request->get('profissional_id');
        $paciente_id = $request->get('paciente_id');
        $situacao = $request->get('situacao');
        $plano_tipo = $request->get('plano_tipo');
        $data_cadastro_inicial = $request->get('data_cadastro_inicial');
        $data_cadastro_final = $request->get('data_cadastro_final');

        $query = MovimentacaoGuia::select('movimentacoes_guias.*', 'pacientes.name as paciente', 'cadastro.id as usuario', 'cadastro.name as nome_usuario', 'profissionais.name as profissional', \DB::raw("(CASE WHEN pacientes.titular_id IS NULL THEN COALESCE(pacientes.nim, '') ELSE CONCAT(COALESCE(titular.nim, ''), '.', COALESCE(pacientes.ordem, '')) END) AS nim"))
                                ->leftJoin('users as pacientes', 'movimentacoes_guias.paciente_id', '=', 'pacientes.id')
                                ->leftJoin('users as titular', 'pacientes.titular_id', '=', 'titular.id')
                                ->leftJoin('users as cadastro', 'movimentacoes_guias.usuario_cadastro', '=', 'cadastro.id')
                                ->leftJoin('users as profissionais', 'movimentacoes_guias.profissional_id', '=', 'profissionais.id');

        // Ajusta queries de acordo com parâmetros
        if(!empty($profissional_id))
            $query = $query->where('movimentacoes_guias.profissional_id', $profissional_id);

        if(!empty($paciente_id))
            $query = $query->where('movimentacoes_guias.paciente_id', $paciente_id);

        if(!empty($situacao))
            $query = $query->where('movimentacoes_guias.situacao', $situacao);

        if(!empty($plano_tipo))
            $query = $query->where('movimentacoes_guias.plano_tipo', $plano_tipo);

        // Período de data
        if(!empty($data_cadastro_inicial) && !empty($data_cadastro_final)){
            $query = $query->whereDate('movimentacoes_guias.created_at', '>=', $data_cadastro_inicial);
            $query = $query->whereDate('movimentacoes_guias.created_at', '<=', $data_cadastro_final);
        }
        else if(!empty($data_cadastro_inicial))
            $query = $query->whereDate('movimentacoes_guias.created_at', $data_cadastro_inicial);

        $guias = $query->get();

        // Corrige valores
        for($i = 0; $i < count($guias); $i++){
            $guia = $guias[$i];

            $guia['valor_total'] = number_format($guia['valor_total'], 2);
            $guia['valor_repasse'] = number_format($guia['valor_repasse'], 2);
        }

        return response()->json(array(
            'status' => 'sucesso',
            'data' => $guias,
        ), 200);
    }

    /**
     * Pega guias por paciente
     *
     * @return \Illuminate\Http\Response
     */
    public function getGuiasPaciente(Request $request)
    {
        $profissional_id = $request->get('profissional_id');
        $paciente_id = $request->get('paciente_id');
        $situacao_excluir = $request->get('situacao_excluir');

        $query = MovimentacaoGuia::select('movimentacoes_guias.*', 'pacientes.name as paciente', 'profissionais.name as profissional')
                                ->leftJoin('users as pacientes', 'movimentacoes_guias.paciente_id', '=', 'pacientes.id')
                                ->leftJoin('users as profissionais', 'movimentacoes_guias.profissional_id', '=', 'profissionais.id')
                                ->where('movimentacoes_guias.situacao', '<>', 'F');

        // Ajusta queries de acordo com parâmetros
        if(!empty($profissional_id))
            $query = $query->where('movimentacoes_guias.profissional_id', $profissional_id);

        if(!empty($paciente_id))
            $query = $query->where('movimentacoes_guias.paciente_id', $paciente_id);

        // Excluir alguma situação específica
        if(!empty($situacao_excluir))
            $query = $query->where('movimentacoes_guias.situacao', '<>', $situacao_excluir);

        // Controle para não exibir todas as guias quando não tem paciente e profissional
        if(empty($profissional_id) && empty($paciente_id))
            $guias = [];
        else{
            $guias = $query->get();

            // Corrige valores
            for($i = 0; $i < count($guias); $i++){
                $guia = $guias[$i];

                $guia['valor_total'] = number_format($guia['valor_total'], 2);
                $guia['valor_repasse'] = number_format($guia['valor_repasse'], 2);
            }

            $guias = $guias->pluck('valor_total', 'id');
            $guias->prepend('Selecione uma guia', '');
        }

        return response()->json(array(
            'status' => 'sucesso',
            'data' => $guias,
        ), 200);
    }

    /**
     * Pega procedimentos guia
     *
     * @return \Illuminate\Http\Response
     */
    public function getProcedimentosGuia(Request $request)
    {
        $guia_id = $request->get('guia_id');

        $procedimentos = MovimentacaoGuiaProcedimento::select('movimentacao_guia_procedimentos.*', 'procedimentos.descricao as procedimento', 'procedimentos.id as id_procedimento', 'procedimentos.preparo as preparo')
                                            ->leftJoin('procedimentos', 'movimentacao_guia_procedimentos.procedimento_id', '=', 'procedimentos.id')
                                            ->where('movimentacao_guia_id', $guia_id);

        if($request->get('is_agendamento'))
            $procedimentos->where('movimentacao_guia_procedimentos.situacao', '<>', 'F');
        
        $procedimentos = $procedimentos->get();

        for($i = 0; $i < count($procedimentos); $i++){
            $procedimento = $procedimentos[$i];

            $procedimento['valor_total'] = number_format($procedimento['valor_total'], 2);
            $procedimento['valor'] = number_format($procedimento['valor'], 2);
        }

        return response()->json(array(
            'status' => 'sucesso',
            'data' => $procedimentos
        ), 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\MovimentacaoGuia  $movimentacaoGuia
     * @return \Illuminate\Http\Response
     */
    public function editar(Request $request)
    {
        // Pega lista pacientes
        // $pacientes = User::select(DB::raw("CONCAT(nim, '  ', name) AS name"), 'id')
        //                             ->where('paciente_id', '<>', null)
        //                             ->orderBy('name', 'asc')
        //                             ->get();

        $pacientes = DB::table('users as u')
                    ->select("u.id AS id", \DB::raw("(CASE WHEN u.titular_id IS NULL THEN CONCAT(COALESCE(u.nim, ''), '  ', COALESCE(u.name, '')) ELSE CONCAT(COALESCE(t.nim, ''), '.', COALESCE(u.ordem, ''), '  ', COALESCE(u.name, '')) END) AS name"))
                    ->leftJoin('users AS t', 'u.titular_id', '=', 't.id')
                    ->where('u.paciente_id', '<>', null)
                    ->orderBy('u.name', 'ASC')
                    ->get();
                    
        $pacientes = $pacientes->pluck('name', 'id');
        $pacientes->prepend('Selecione um paciente', '');

        // Pega lista profissionais e/ou empresas
        $profissionais = User::where('profissional_id', '<>', null)
                            ->orWhere('empresa_id', '<>', null)
                            ->orderBy('name', 'asc')
                            ->get();
        $profissionais = $profissionais->pluck('name', 'id');
        $profissionais->prepend('Selecione um profissional', '');

        return view('guias.edit', compact('pacientes', 'profissionais'));
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

            $guia = [];

            // Cria Guia
            $guia['profissional_id'] = $request->get('profissional_id');
            $guia['paciente_id'] = $request->get('paciente_id');
            $guia['usuario_cadastro'] = Auth::id();
            $guia['situacao'] = $request->get('orcamento');
            $guia['valor_total'] = 0;
            $guia['plano_tipo'] = $request->get('plano_tipo');

            // Pega Procedimentos
            $procedimentos = $request->get('procedimentos');
            $procedimentos_guia = [];
            $procedimento_guia = [];

            // Valores guia
            $valor_repasse = 0;
            $valor_total = 0;

            // Cria Procedimentos
            for($i = 0; $i < count($procedimentos); $i++){
                $procedimento = $procedimentos[$i];

                $repasse = 0;

                // Verifica se valor repasse é em R$ ou %
                if($procedimento['valor_repasse'] != 0)
                    $repasse = $procedimento['valor_repasse'] * $procedimento['quantidade'];
                else if($procedimento['percentual_repasse'] != 0)
                    $repasse = $procedimento['valor_total'] * $procedimento['percentual_repasse'] / 100;

                $valor_repasse += $repasse;
                $valor_total += $procedimento['valor_total'];

                // Cria Procedimento Guia
                $procedimento_guia['valor'] = $procedimento['valor'];
                $procedimento_guia['quantidade'] = $procedimento['quantidade'];
                $procedimento_guia['valor_total'] = $procedimento['valor_total'];
                $procedimento_guia['valor_repasse'] = $repasse;
                $procedimento_guia['alterado'] = $procedimento['alterado'];
                $procedimento_guia['profissional_id'] = $request->get('profissional_id');
                $procedimento_guia['procedimento_id'] = $procedimento['procedimento_id'];
                $procedimento_guia['situacao'] = 'A';
                $procedimento_guia['observacao'] = $procedimento['observacao'];

                $procedimentos_guia[] = $procedimento_guia;
                $procedimento_guia = [];
            }

            // Grava Guia
            $guia['valor_repasse'] = $valor_repasse;
            $guia['valor_total'] = $valor_total ;
            $retorno_guia = MovimentacaoGuia::create($guia);

            $retorno_procedimentos = [];
            // Grava ID Guia nos procedimentos
            for($i = 0; $i < count($procedimentos_guia) ; $i++){
                $procedimento = $procedimentos_guia[$i];

                $procedimento['movimentacao_guia_id'] = $retorno_guia['id'];

                // Grava procedimentos Guia
                $retorno_procedimentos[] = MovimentacaoGuiaProcedimento::create($procedimento);
            }

            // Gera financeiro, se não for orçamento
            if($request->get('orcamento') != 'O'){
                // Gera financeiro guia (contas a receber do PACIENTE)
                $financeiro = new \App\Http\Controllers\FinanceiroController();

                $parcelas = [];
                $parcela = [];
                $parcela['valor'] = $guia['valor_total'];//$p['valor'];
                $parcela['vencimento'] = Carbon::now();//->addMonth($i+1);//$p['data'];
                $parcela['fk_fpg_codigo'] = 1;//$parc['fk_fpg_codigo'];
                $parcela['forma_pagamento'] = 1;//$parc['fk_fpg_codigo'];
                $parcela['taxa'] = 0;//is_null($ptx) ? 0 : $ptx->ptx_valor_taxa ;
                $parcelas[0] = $parcela;

                $financeiro->debitarGuia($guia['paciente_id'], 0, $guia['valor_total'], 'Guia ' . $retorno_guia['id'], $parcelas, $retorno_guia['id']);

                // Gera financeiro guia (contas a pagar para PROFISSIONAL)
                $financeiro->gerarCredito($guia['profissional_id'], 0, $guia['valor_repasse'], 'Repasse Guia ' . $retorno_guia['id'], $retorno_guia['id']);
            }

            return response()->json(array(
                'status' => 'sucesso',
                'guia' => $retorno_guia,
                'procedimentos_guia' => $retorno_procedimentos,
            ), 200);


    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\MovimentacaoGuia  $movimentacaoGuia
     * @return \Illuminate\Http\Response
     */
    public function show(MovimentacaoGuia $movimentacaoGuia)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\MovimentacaoGuia  $movimentacaoGuia
     * @return \Illuminate\Http\Response
     */
    public function edit(MovimentacaoGuia $movimentacaoGuia)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\MovimentacaoGuia  $movimentacaoGuia
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, MovimentacaoGuia $movimentacaoGuia)
    {
        // Deleta informações anteriores
        $guia_id = $request->get('guia_id');
        
        $guia = MovimentacaoGuia::findOrFail($guia_id);

        // $guia = [];

        // Cria Guia
        $guia['profissional_id'] = $request->get('profissional_id');
        $guia['paciente_id'] = $request->get('paciente_id');
        $guia['usuario_cadastro'] = Auth::id();
        $guia['situacao'] = $request->get('orcamento');
        $guia['valor_total'] = 0;
        $guia['plano_tipo'] = $request->get('plano_tipo');

        // Pega Procedimentos
        $procedimentos = $request->get('procedimentos');
        $procedimentos_guia = [];
        $procedimento_guia = [];
        
        // Valores guia
        $valor_repasse = 0;
        $valor_total = 0;

        // Cria Procedimentos
        for($i = 0; $i < count($procedimentos) ; $i++){
            $procedimento = $procedimentos[$i];

            $repasse = 0;

            // Verifica se valor repasse é em R$ ou %
            if($procedimento['valor_repasse'] != 0)
                $repasse = $procedimento['valor_repasse'] * $procedimento['quantidade'];
            else if($procedimento['percentual_repasse'] != 0)
                $repasse = $procedimento['valor_total'] * $procedimento['percentual_repasse'] / 100;

            $valor_repasse += $repasse;
            $valor_total += $procedimento['valor_total'];

            // Cria Procedimento Guia
            $procedimento_guia['valor'] = $procedimento['valor'];
            $procedimento_guia['quantidade'] = $procedimento['quantidade'];
            $procedimento_guia['valor_total'] = $procedimento['valor_total'];
            $procedimento_guia['valor_repasse'] = $repasse;
            $procedimento_guia['alterado'] = $procedimento['alterado'];
            $procedimento_guia['profissional_id'] = $request->get('profissional_id');
            $procedimento_guia['procedimento_id'] = $procedimento['procedimento_id'];
            $procedimento_guia['situacao'] = 'A';
            $procedimento_guia['observacao'] = $procedimento['observacao'];

            $procedimentos_guia[] = $procedimento_guia;
            $procedimento_guia = [];
        }

        // Grava Guia
        $guia['valor_repasse'] = $valor_repasse;
        $guia['valor_total'] = $valor_total ;

        $guia->save();

        MovimentacaoGuiaProcedimento::where('movimentacao_guia_id', $guia_id)->forceDelete();

        $retorno_procedimentos = [];
        // Grava ID Guia nos procedimentos
        for($i = 0; $i < count($procedimentos_guia) ; $i++){
            $procedimento = $procedimentos_guia[$i];

            $procedimento['movimentacao_guia_id'] = $guia_id;

            // Grava procedimentos Guia
            $retorno_procedimentos[] = MovimentacaoGuiaProcedimento::create($procedimento);
        }

        // Alterar financeiro guia

        return response()->json(array(
            'status' => 'sucesso',
            'guia' => $guia,
            'procedimentos_guia' => $retorno_procedimentos,
        ), 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\MovimentacaoGuia  $movimentacaoGuia
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // Soft delete Procedimentos Guia
        MovimentacaoGuiaProcedimento::where('movimentacao_guia_id', $id)->delete();

        // Soft delete Guia
        MovimentacaoGuia::where('id', $id)->delete();

        return response()->json(array(
            'status' => 'sucesso',
            'guia' => $id,
        ), 200);
    }
    
    /**
     * Ajusta situação da guia de acordo com procedimentos.
     *
     */
    public function ajustaSituacaoGuia($id)
    {
        // Pega Guia
        $guia = MovimentacaoGuia::findOrFail($id);
        
        // Pega procedimentos guia
        $procedimentos = MovimentacaoGuiaProcedimento::where('movimentacao_guia_id', $id)->get();

        // Controle de situação da guia
        $aberto = false;
        $parcial = false;
        $fechado = false;
        $situacao = 'A';

        for($i = 0; $i < count($procedimentos); $i++){
            $procedimento = $procedimentos[$i];
            
            if($procedimento['situacao'] == 'A')
                $aberto = true;
            else if($procedimento['situacao'] == 'P')
                $parcial = true;
            else if($procedimento['situacao'] == 'F')
                $fechado = true;
        }

        if($parcial)
            $situacao = 'P';
        else if ($aberto && !$fechado)
            $situacao = 'A';
        else if($aberto && $fechado)
            $situacao = 'P';
        else 
            $situacao = 'F';

        if($guia['situacao'] != $situacao){
            $guia['situacao'] = $situacao;

            $guia->save();
        }
        
        return response()->json(array(
            'status' => 'sucesso',
            'situacao' => $situacao,
        ), 200);
    }

    /**
     * Altera situação da guia
     *
     */
    public function alteraSituacaoGuia(Request $request)
    {
        // Pega Guia
        $guia = MovimentacaoGuia::findOrFail($request->get('id'));

        $situacao = $request->get('situacao');

        if($guia['situacao'] != $situacao){
            $guia['situacao'] = $situacao;

            $guia->save();
        }
        
        return response()->json(array(
            'status' => 'sucesso',
            'situacao' => $situacao,
        ), 200);
    }
}
