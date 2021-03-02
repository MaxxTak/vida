<?php

namespace App\Http\Controllers;

use App\Models\Prontuario;
use Illuminate\Http\Request;
use App\Models\Especialidade;
use App\Models\ProntuarioCampo;
use Illuminate\Support\Facades\Auth;
use App\Models\ProntuarioPaciente;
use App\Models\ProntuarioPacienteCampos;

class ProntuarioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Retorna itens
        $items = Prontuario::select('prontuarios.*', 'especialidades.titulo as especialidade')
                        ->leftJoin('especialidades', 'prontuarios.especialidade_id', '=', 'especialidades.id')
                        ->get();

        return view('prontuarios.index', compact('items'));
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

        $campos = self::getListCamposProntuario();

        return view('prontuarios.create', compact('especialidades', 'campos'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Cria Prontuário
        $prontuario = [];
        $prontuario['descricao'] = $request->get('descricao');
        $prontuario['usuario_cadastro'] = Auth::id();
        $prontuario['especialidade_id'] = $request->get('especialidade_id');

        // Cria array Campos prontuário
        $campos = $request->get('campos');

        $campos_prontuario = [];
        $campo_prontuario = [];

        for($i = 0; $i < count($campos); $i++){
            $campo = $campos[$i];

            $campo_prontuario['sequencial'] = $campo['sequencial'];
            $campo_prontuario['campo'] = $campo['campo'];
            $campo_prontuario['descricao'] = $campo['descricao'];
            
            $campos_prontuario[] = $campo_prontuario;
            $campo_prontuario = [];
        }

        // Grava Prontuário
        $retorno_prontuario  = Prontuario::create($prontuario);

        // Grava ID Prontuario nos campos
        $retorno_campos = [];
        for($i = 0; $i < count($campos_prontuario) ; $i++){
            $campo = $campos_prontuario[$i];

            $campo['prontuario_id'] = $retorno_prontuario['id'];

            // Grava campo prontuario
            $retorno_campos[] = ProntuarioCampo::create($campo);
        }

        // Retorno
        return response()->json(array(
            'status' => 'sucesso',
            'prontuario' => $retorno_prontuario,
            'prontuario_campos' => $retorno_campos,
        ), 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Prontuario  $prontuario
     * @return \Illuminate\Http\Response
     */
    public function show(Prontuario $prontuario)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Prontuario  $prontuario
     * @return \Illuminate\Http\Response
     */
    public function edit(Prontuario $prontuario)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Prontuario  $prontuario
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Prontuario $prontuario)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Prontuario  $prontuario
     * @return \Illuminate\Http\Response
     */
    public function destroy(Prontuario $prontuario)
    {
        //
    }

    public function getProntuariosPaciente(Request $request){
        // Retorna itens
        $prontuarios = ProntuarioPaciente::select('prontuario_pacientes.*', 'prontuarios.descricao as descricao')
                        ->leftJoin('prontuarios', 'prontuarios.id', '=', 'prontuario_pacientes.prontuario_id');

        $term = $request->get('term');

        if($term)
            $prontuarios->where('prontuarios.descricao', 'like', '%' . $term . '%');
        
        $prontuarios = $prontuarios->orderBy('prontuario_pacientes.id')
                                ->get();

        return response()->json(array(
            'status' => 'sucesso',
            'results' => $prontuarios,
        ), 200);
    }

    public function getCamposProntuarioPaciente(Request $request){
        $id = $request->get('prontuario_paciente_id');

        $campos = ProntuarioPacienteCampos::where('prontuario_paciente_id', $id)->orderBy('sequencial')->get();

        return response()->json(array(
            'status' => 'sucesso',
            'campos' => $campos,
        ), 200);
    }

    public function getCamposProntuario(Request $request){
        $id = $request->get('prontuario_id');

        $campos = ProntuarioCampo::where('prontuario_id', $id)->orderBy('sequencial')->get();

        return response()->json(array(
            'status' => 'sucesso',
            'campos' => $campos,
        ), 200);
    }

    public function gravaProntuario(Request $request){
        // Grava Prontuário Paciente
        $prontuario_paciente = [];
        $prontuario_paciente['paciente_id'] = $request->get('paciente_id');
        $prontuario_paciente['profissional_id'] = $request->get('profissional_id');
        $prontuario_paciente['prontuario_id'] = $request->get('prontuario_id');

        $retorno_prontuario_paciente = ProntuarioPaciente::create($prontuario_paciente);

        // Grava campos Prontuário Paciente
        $campos = $request->get('campos');
        $campos_prontuario = self::getListCamposProntuario();

        $retorno_campos = [];
        $prontuario_paciente_campo = [];

        for($i = 0; $i < count($campos); $i++){
            $campo = $campos[$i];

            $prontuario_paciente_campo['sequencial'] = $i + 1;
            $prontuario_paciente_campo['campo'] = $campo['name'];
            $prontuario_paciente_campo['descricao'] = $campos_prontuario[$campo['name']];
            $prontuario_paciente_campo['valor'] = $campo['value'];
            $prontuario_paciente_campo['prontuario_paciente_id'] = $retorno_prontuario_paciente['id'];

            $retorno_campos[] = ProntuarioPacienteCampos::create($prontuario_paciente_campo);
            $prontuario_paciente_campo = [];
        }

        return response()->json(array(
            'status' => 'sucesso',
            'prontuario_paciente' => $retorno_prontuario_paciente,
            'retorno_campos' => $retorno_campos,
        ), 200);
    }

    public function getListCamposProntuario(){
        return [
            'observacoes' => 'Observações', 
            'ocupacao' => 'Ocupação', 
            'motivo_consulta' => 'Motivo Consulta', 
            'encaminhado' => 'Encaminhado',
            'doencas' => 'Doenças',
            'medicamentos' => 'Medicamentos',
            'atividades_fisicas' => 'Atividades Físicas',
            'exames' => 'Exames',
            'intestino' => 'Intestino',
            'hidratacao' => 'Hidratação',
            'peso_atual' => 'Peso Atual',
            'altura' => 'Altura',
            'imc' => 'IMC',
            'percentual_gordura' => 'Percentual Gordura',
            'pressao_pulso' => 'Pressão Pulso',
            'pressao_arterial' => 'Pressão Arterial',
            'ab' => 'AB',
            'quadril' => 'Quadril',
            'metas' => 'Metas',
            'diagnostico_clinico' => 'Diagnóstico Clínico',
            'sinais_vitais' => 'Sinais Vitais',
            'qualidade_dor' => 'Qualidade Dor',
            'profundidade_dor' => 'Profundidade Dor',
            'frequencia_dor' => 'Frequência Dor',
            't1' => 'T1',
            't2' => 'T2',
            't3' => 'T3',
            'queixa_principal' => 'Queixa Principal',
            'hma' => 'HMA',
            'tratamentos_previos' => 'Tratamentos Prévios',
            'exames_complementares' => 'Exames Complementares',
            'inspecao' => 'Inspeção',
            'palpacao' => 'Palpação',
            'adm_ativa' => 'Adm Ativa',
            'adm_passiva' => 'Adm Passiva',
            'tuc' => 'TUC',
            'testes_especiais' => 'Testes Especiais',
        ];
    }
}
