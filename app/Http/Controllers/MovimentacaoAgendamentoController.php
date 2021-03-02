<?php

namespace App\Http\Controllers;

use App\Models\MovimentacaoAgendamento;
use Illuminate\Http\Request;
use App\Models\Sala;
use Illuminate\Support\Facades\Auth;
use App\Models\MovimentacaoGuia;
use App\Models\MovimentacaoAgendamentoProcedimento;
use App\Models\MovimentacaoGuiaProcedimento;
use Illuminate\Support\Facades\DB;
use Faker\Provider\zh_TW\DateTime;
use App\Models\Prontuario;
use App\User;
use Faker\Generator as Faker;

class MovimentacaoAgendamentoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pacientes = DB::table('users as u')
                    ->select("u.id AS id", \DB::raw("(CASE WHEN u.titular_id IS NULL THEN CONCAT(COALESCE(u.nim, ''), '  ', COALESCE(u.name, '')) ELSE CONCAT(COALESCE(t.nim, ''), '.', COALESCE(u.ordem, ''), '  ', COALESCE(u.name, '')) END) AS name"))
                    ->leftJoin('users AS t', 'u.titular_id', '=', 't.id')
                    ->where('u.paciente_id', '<>', null)
                    ->orderBy('u.name', 'asc')
                    ->get();

        // dd($pacientes);

        $pacientes = $pacientes->pluck('name', 'id');
        $pacientes->prepend('Selecione um paciente', '');

        // Pega lista profissionais e/ou empresas
        $profissionais = User::where('profissional_id', '<>', null)
                            ->orWhere('empresa_id', '<>', null)
                            ->orderBy('name', 'asc')
                            ->get();
        $profissionais = $profissionais->pluck('name', 'id');
        $profissionais->prepend('Selecione um profissional', '');

        // Pega lista de salas
        $salas = Sala::orderBy('descricao', 'asc')
                            ->get();

        $salas = $salas->pluck('descricao', 'id');
        $salas->prepend('Selecione uma sala', '');

        return view('agendamentos.index', compact('pacientes', 'profissionais', 'salas'));
    }

    /**
     * Consulta médica de um agendamento
     *
     * @return \Illuminate\Http\Response
     */
    public function consulta()
    {
        $prontuarios = Prontuario::orderBy('id')->get();
        $prontuarios = $prontuarios->pluck('descricao', 'id');
        $prontuarios->prepend('Selecione um prontuário', '');

        return view('agendamentos.consulta', compact('prontuarios'));
    }

    /**
     * Históricos de agendamento
     *
     * @return \Illuminate\Http\Response
     */
    public function historico()
    {
        $pacientes = DB::table('users as u')
                    ->select("u.id AS id", \DB::raw("(CASE WHEN u.titular_id IS NULL THEN CONCAT(COALESCE(u.nim, ''), '  ', COALESCE(u.name, '')) ELSE CONCAT(COALESCE(t.nim, ''), '.', COALESCE(u.ordem, ''), '  ', COALESCE(u.name, '')) END) AS name"))
                    ->leftJoin('users AS t', 'u.titular_id', '=', 't.id')
                    ->where('u.paciente_id', '<>', null)
                    ->orderBy('u.name', 'asc')
                    ->get();

        // dd($pacientes);

        $pacientes = $pacientes->pluck('name', 'id');
        $pacientes->prepend('Selecione um paciente', '');

        // Pega lista profissionais e/ou empresas
        $profissionais = User::where('profissional_id', '<>', null)
                            ->orWhere('empresa_id', '<>', null)
                            ->orderBy('name', 'asc')
                            ->get();
        $profissionais = $profissionais->pluck('name', 'id');
        $profissionais->prepend('Selecione um profissional', '');

        // Pega lista de salas
        $salas = Sala::orderBy('descricao', 'asc')
                            ->get();

        $salas = $salas->pluck('descricao', 'id');
        $salas->prepend('Selecione uma sala', '');

        return view('agendamentos.historico', compact('pacientes', 'profissionais', 'salas'));
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
     * Pega Agendamentos
     *
     * @return \Illuminate\Http\Response
     */
    public function getAgendamentos(Request $request)
    {
        $profissional_id = $request->get('profissional_id');
        $paciente_id = $request->get('paciente_id');
        $sala_id = $request->get('sala_id');
        $guia_id = $request->get('guia_id');
        $situacao = $request->get('situacao');
        $data_inicial = $request->get('data_inicial');
        $data_final = $request->get('data_final');

        // $agendamentos = MovimentacaoAgendamento::latest('updated_at')->get();

        $query = MovimentacaoAgendamento::select('movimentacoes_agendamentos.*', 'pacientes.name as paciente', 'profissionais.name as profissional', 'salas.descricao', 'pacientes.telefone as telefone', 'pacientes.telefone2 as telefone2', \DB::raw("(CASE WHEN pacientes.titular_id IS NULL THEN COALESCE(pacientes.nim, '') ELSE CONCAT(COALESCE(titular.nim, ''), '.', COALESCE(pacientes.ordem, '')) END) AS nim"))
                                ->leftJoin('users as pacientes', 'movimentacoes_agendamentos.paciente_id', '=', 'pacientes.id')
                                ->leftJoin('users as titular', 'pacientes.titular_id', '=', 'titular.id')
                                ->leftJoin('salas', 'movimentacoes_agendamentos.sala_id', '=', 'salas.id')
                                ->leftJoin('users as profissionais', 'movimentacoes_agendamentos.profissional_id', '=', 'profissionais.id');

        // Ajusta queries de acordo com parâmetros
        if(!empty($data_inicial) && !empty($data_final))
            $query = $query->whereBetween('start', array($data_inicial, $data_final));

        if(!empty($profissional_id))
            $query = $query->where('movimentacoes_agendamentos.profissional_id', $profissional_id);

        if(!empty($paciente_id))
            $query = $query->where('movimentacoes_agendamentos.paciente_id', $paciente_id);

        if(!empty($sala_id))
            $query = $query->where('movimentacoes_agendamentos.sala_id', $sala_id);

        if(!empty($guia_id))
            $query = $query->where('movimentacoes_agendamentos.movimentacao_guia_id', $guia_id);

        if(!empty($situacao))
            $query = $query->whereIn('movimentacoes_agendamentos.situacao', $situacao);

        $agendamentos = $query->get();

        return response()->json(array(
            'status' => 'sucesso',
            'agendamentos' => $agendamentos,
        ), 200);
    }

    public function getAgendamentosData(Request $request)
    {
        $data_inicial = $request->get('data_inicial');
        $data_final = $request->get('data_final');

        $query = MovimentacaoAgendamento::select('movimentacoes_agendamentos.*', 'pacientes.name as paciente', 'profissionais.name as profissional', 'salas.descricao')
                                ->leftJoin('users as pacientes', 'movimentacoes_agendamentos.paciente_id', '=', 'pacientes.id')
                                ->leftJoin('salas', 'movimentacoes_agendamentos.sala_id', '=', 'salas.id')
                                ->leftJoin('users as profissionais', 'movimentacoes_agendamentos.profissional_id', '=', 'profissionais.id')
                                ->whereBetween('start', array($data_inicial, $data_final))
                                ->orderBy('start', 'ASC');

        $agendamentos = $query->get();

        return response()->json(array(
            'status' => 'sucesso',
            'agendamentos' => $agendamentos,
        ), 200);
    }

    /**
     * Pega Agendamentos
     *
     * @return \Illuminate\Http\Response
     */
    public function getAgendamentosHistorico(Request $request)
    {
        $profissional_id = $request->get('profissional_id');
        $paciente_id = $request->get('paciente_id');
        $sala_id = $request->get('sala_id');
        $guia_id = $request->get('guia_id');
        $situacao = $request->get('situacao');
        $data_inicial = $request->get('data_inicial');
        $data_final = $request->get('data_final');

        $tem_filtro = false;

        // $agendamentos = MovimentacaoAgendamento::latest('updated_at')->get();

        
        $query = MovimentacaoAgendamento::select('movimentacoes_agendamentos.*', 'pacientes.name as paciente', 'profissionais.name as profissional', 'salas.descricao')
                                ->leftJoin('users as pacientes', 'movimentacoes_agendamentos.paciente_id', '=', 'pacientes.id')
                                ->leftJoin('salas', 'movimentacoes_agendamentos.sala_id', '=', 'salas.id')
                                ->leftJoin('users as profissionais', 'movimentacoes_agendamentos.profissional_id', '=', 'profissionais.id');

        // Ajusta queries de acordo com parâmetros
        if(!empty($data_inicial) && !empty($data_final))
        {
            $query = $query->whereDate('start', '>=', $data_inicial);
            $query = $query->whereDate('start', '<=', $data_final);
            $tem_filtro = true;
        }

        if(!empty($profissional_id))
        {
            $query = $query->where('movimentacoes_agendamentos.profissional_id', $profissional_id);
            $tem_filtro = true;
        }
        if(!empty($paciente_id))
        {
            $query = $query->where('movimentacoes_agendamentos.paciente_id', $paciente_id);
            $tem_filtro = true;
        }

        if(!empty($sala_id))
        {
            $query = $query->where('movimentacoes_agendamentos.sala_id', $sala_id);
            $tem_filtro = true;
        }

        if(!empty($guia_id))
        {
            $query = $query->where('movimentacoes_agendamentos.movimentacao_guia_id', $guia_id);
            $tem_filtro = true;
        }            

        if(!empty($situacao) && ($situacao <> 'X'))
        {
            $query = $query->where('movimentacoes_agendamentos.situacao', $situacao);
            $tem_filtro = true;
        }else if($situacao == 'X')
        {
            $query = $query->onlyTrashed();
            $tem_filtro = true;
        }else if (empty($situacao))
        {
            $query = $query->withTrashed();
            // $tem_filtro = true;
        }

        $agendamentos = [];

        if($tem_filtro)
            $agendamentos = $query->get();

        return response()->json(array(
            'status' => 'sucesso',
            'agendamentos' => $agendamentos,
        ), 200);
    }

    /**
     * Pega Agendamentos
     *
     * @return \Illuminate\Http\Response
     */
    public function getAgendamento(Request $request)
    {
        $id = $request->get('agendamento_id');
        
        $agendamento = MovimentacaoAgendamento::select('movimentacoes_agendamentos.*', 'pacientes.name as paciente', 'profissionais.name as profissional', 'salas.descricao')
                                ->leftJoin('users as pacientes', 'movimentacoes_agendamentos.paciente_id', '=', 'pacientes.id')
                                ->leftJoin('salas', 'movimentacoes_agendamentos.sala_id', '=', 'salas.id')
                                ->leftJoin('users as profissionais', 'movimentacoes_agendamentos.profissional_id', '=', 'profissionais.id')
                                ->where('movimentacoes_agendamentos.id', $id)
                                ->get()
                                ->first();

        return response()->json(array(
            'status' => 'sucesso',
            'agendamento' => $agendamento,
        ), 200);
    }

    /**
     * Veririca conflito de agendamentos
     * 
     */
    public function verificaConflito(Request $request)
    {
        $profissional_id = $request->get('profissional_id');
        $paciente_id = $request->get('paciente_id');
        $sala_id = $request->get('sala_id');
        $guia_id = $request->get('guia_id');
        $start = $request->get('start');
        $start_date = $request->get('start_date');
        $end = $request->get('end');
        $allday = $request->get('allday');
        $tem_conflito = false;

        if($allday == 'S'){
            // Verifica conflito por profissional
            $agendamento = MovimentacaoAgendamento::select('movimentacoes_agendamentos.*', 'profissionais.name as profissional')
                                                ->leftJoin('users as profissionais', 'movimentacoes_agendamentos.profissional_id', '=', 'profissionais.id')
                                                ->where('movimentacoes_agendamentos.profissional_id', $profissional_id)
                                                ->where('movimentacoes_agendamentos.start', $start)
                                                ->where('movimentacoes_agendamentos.allDay', true)
                                                ->whereIn('movimentacoes_agendamentos.situacao', ['A', 'C', 'F'])
                                                ->get();

            $tem_conflito = count($agendamento) || false;

            // Verifica se já possui agendamento, antes de fechar agenda
            $agendamento = MovimentacaoAgendamento::select('movimentacoes_agendamentos.*', 'pacientes.name as paciente', 'profissionais.name as profissional', 'salas.descricao as sala')
                                                ->leftJoin('users as pacientes', 'movimentacoes_agendamentos.paciente_id', '=', 'pacientes.id')
                                                ->leftJoin('salas', 'movimentacoes_agendamentos.sala_id', '=', 'salas.id')
                                                ->leftJoin('users as profissionais', 'movimentacoes_agendamentos.profissional_id', '=', 'profissionais.id')
                                                ->where('movimentacoes_agendamentos.profissional_id', $profissional_id)
                                                ->whereDate('movimentacoes_agendamentos.start', $start)
                                                ->whereIn('movimentacoes_agendamentos.situacao', ['A', 'C', 'F'])
                                                ->get();

            $tem_conflito = count($agendamento) || false;
        }else{
            // Verifica conflito por profissional
            $agendamento = MovimentacaoAgendamento::select('movimentacoes_agendamentos.*', 'pacientes.name as paciente', 'profissionais.name as profissional', 'salas.descricao as sala')
                                                ->leftJoin('users as pacientes', 'movimentacoes_agendamentos.paciente_id', '=', 'pacientes.id')
                                                ->leftJoin('salas', 'movimentacoes_agendamentos.sala_id', '=', 'salas.id')
                                                ->leftJoin('users as profissionais', 'movimentacoes_agendamentos.profissional_id', '=', 'profissionais.id')
                                                ->where('movimentacoes_agendamentos.profissional_id', $profissional_id)
                                                ->where('movimentacoes_agendamentos.start', '<', $end)
                                                ->where('movimentacoes_agendamentos.end', '>', $start)
                                                ->whereIn('movimentacoes_agendamentos.situacao', ['A', 'C', 'F'])
                                                ->get();

            $tem_conflito = count($agendamento) || false;

            // Verifica conflito por paciente
            if(!$tem_conflito){
                $agendamento = MovimentacaoAgendamento::select('movimentacoes_agendamentos.*', 'pacientes.name as paciente', 'profissionais.name as profissional', 'salas.descricao as sala')
                                                    ->leftJoin('users as pacientes', 'movimentacoes_agendamentos.paciente_id', '=', 'pacientes.id')
                                                    ->leftJoin('salas', 'movimentacoes_agendamentos.sala_id', '=', 'salas.id')
                                                    ->leftJoin('users as profissionais', 'movimentacoes_agendamentos.profissional_id', '=', 'profissionais.id')
                                                    ->where('movimentacoes_agendamentos.paciente_id', $paciente_id)
                                                    ->where('movimentacoes_agendamentos.start', '<', $end)
                                                    ->where('movimentacoes_agendamentos.end', '>', $start)
                                                    ->whereIn('movimentacoes_agendamentos.situacao', ['A', 'C', 'F'])
                                                    ->get();

                $tem_conflito = count($agendamento) || false;
            }
            
            // Verifica conflito por sala
            if(!$tem_conflito){
                $agendamento = MovimentacaoAgendamento::select('movimentacoes_agendamentos.*', 'pacientes.name as paciente', 'profissionais.name as profissional', 'salas.descricao as sala')
                                                    ->leftJoin('users as pacientes', 'movimentacoes_agendamentos.paciente_id', '=', 'pacientes.id')
                                                    ->leftJoin('salas', 'movimentacoes_agendamentos.sala_id', '=', 'salas.id')
                                                    ->leftJoin('users as profissionais', 'movimentacoes_agendamentos.profissional_id', '=', 'profissionais.id')
                                                    ->where('movimentacoes_agendamentos.sala_id', $sala_id)
                                                    ->where('movimentacoes_agendamentos.start', '<', $end)
                                                    ->where('movimentacoes_agendamentos.end', '>', $start)
                                                    ->whereIn('movimentacoes_agendamentos.situacao', ['A', 'C', 'F'])
                                                    ->get();

                $tem_conflito = count($agendamento) || false;
            }

            // Verifica se profissional está com agenda fechada
            if(!$tem_conflito){
                $agendamento = MovimentacaoAgendamento::select('movimentacoes_agendamentos.*', 'profissionais.name as profissional')
                                                    ->leftJoin('users as pacientes', 'movimentacoes_agendamentos.paciente_id', '=', 'pacientes.id')
                                                    ->leftJoin('salas', 'movimentacoes_agendamentos.sala_id', '=', 'salas.id')
                                                    ->leftJoin('users as profissionais', 'movimentacoes_agendamentos.profissional_id', '=', 'profissionais.id')
                                                    ->where('movimentacoes_agendamentos.profissional_id', $profissional_id)
                                                    ->whereDate('movimentacoes_agendamentos.start', $start_date)
                                                    ->where('movimentacoes_agendamentos.allDay', true)
                                                    ->whereIn('movimentacoes_agendamentos.situacao', ['A', 'C', 'F'])
                                                    ->get();

                $tem_conflito = count($agendamento) || false;
            }
        }

        return response()->json(array(
            'status' => 'sucesso',
            'agendamento' => $agendamento,
            'tem_conflito' => $tem_conflito,
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
        $agendamento = [];

        $allday = $request->get('allday');

        // Cria Agendamento
        $agendamento['profissional_id'] = $request->get('profissional_id');
        $agendamento['usuario_cadastro'] = Auth::id();
        $agendamento['start'] = $request->get('start');
        $agendamento['end'] = $request->get('end');
        $agendamento['observacao'] = $request->get('observacao');

        $retorno_guia = null;
        
        // Informações diferenciadas para eventos dia inteiro
        if($allday == 'S'){
            $agendamento['allDay'] = true;
            $agendamento['situacao'] = 'C';
        }else{
            $agendamento['allDay'] = false;
            $agendamento['situacao'] = 'A';
            $agendamento['paciente_id'] = $request->get('paciente_id');
            $agendamento['sala_id'] = $request->get('sala_id');

            // Vincular Guia
            if(empty($request->get('guia_id'))){
                $guia = [];

                // Cria Guia
                $guia['profissional_id'] = $request->get('profissional_id');
                $guia['paciente_id'] = $request->get('paciente_id');
                $guia['usuario_cadastro'] = Auth::id();
                $guia['situacao'] = 'A';
                $guia['valor_total'] = 0;
                
                $retorno_guia = MovimentacaoGuia::create($guia);
                
                $agendamento['movimentacao_guia_id'] = $retorno_guia['id'];
            }else{
                $agendamento['movimentacao_guia_id'] = $request->get('guia_id');
            }
        }

        $retorno_agendamento = MovimentacaoAgendamento::create($agendamento);

        return response()->json(array(
            'status' => 'sucesso',
            'agendamento' => $agendamento,
            'retorno' => $retorno_agendamento,
            'retorno_guia' => $retorno_guia
        ), 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\MovimentacaoAgendamento  $movimentacaoAgendamento
     * @return \Illuminate\Http\Response
     */
    public function show(MovimentacaoAgendamento $movimentacaoAgendamento)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\MovimentacaoAgendamento  $movimentacaoAgendamento
     * @return \Illuminate\Http\Response
     */
    public function edit(MovimentacaoAgendamento $movimentacaoAgendamento)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\MovimentacaoAgendamento  $movimentacaoAgendamento
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // $id = $request->get('id');
        $situacao = $request->get('situacao');

        $agendamento = MovimentacaoAgendamento::findOrFail($id);

        $agendamento->situacao = $situacao;

        // Finalizar procedimento
        $procedimentos = [];
        if($situacao == 'F'){
            $procedimentos = $request->get('procedimentos');

            if($procedimentos){
                for($i = 0; $i < count($procedimentos); $i++){
                    $procedimento = $procedimentos[$i];
                    
                    // Cria procedimentos
                    $procedimentoAg = [];
    
                    $procedimentoAg['movimentacao_agendamento_id'] = $id;
                    $procedimentoAg['movimentacao_guia_procedimento_id'] = $procedimento['id'];
                    $procedimentoAg['usuario_cadastro'] = Auth::id();
                    $procedimentoAg['situacao'] = $procedimento['situacao'];
    
                    MovimentacaoAgendamentoProcedimento::create($procedimentoAg);
    
                    // Altera situação procedimentos guia
                    $procedimentoGuia = MovimentacaoGuiaProcedimento::findOrFail($procedimento['id']);
    
                    $procedimentoGuia['situacao'] = $procedimento['situacao'];
    
                    $procedimentoGuia->save();
                }
            }
        }

        // Salva agendamento
        $agendamento->save();

        // Ajustar situação guia
        $movGuia = new \App\Http\Controllers\MovimentacaoGuiaController();
        $movGuia->ajustaSituacaoGuia($agendamento['movimentacao_guia_id']);

        return response()->json(array(
            'status' => 'sucesso',
            'agendamento' => $agendamento,
            'procedimentos' => $procedimentos
        ), 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\MovimentacaoAgendamento  $movimentacaoAgendamento
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // Soft delete Guia
        MovimentacaoAgendamento::where('id', $id)->delete();

        return response()->json(array(
            'status' => 'sucesso',
            'agendamento' => $id,
        ), 200);
    }
}
