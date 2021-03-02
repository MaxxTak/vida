<?php

namespace App\Http\Controllers;

use App\Http\Requests\PermissoesRequest;
use App\Models\GrupoPermissoes;
use App\Models\Permissao;
use App\Models\PessoaGrupo;
use App\Models\RelacaoPermissoesGrupo;
use App\User;
use Illuminate\Http\Request;

class PermissaoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // retorna para a página de grupo de permissões
        $permissoes = GrupoPermissoes::with('permissao.permissao')->get();

        return view('permissao.index',['permissoes'=>collect($permissoes->all())]);
    }

    public function retornarPaciente(){
        $pacientes = User::whereNotNull('paciente_id')->get();
        $pacientes = $pacientes->pluck('name','id');
        $pacientes->prepend('Selecione um Paciente','');

        $permissoes = GrupoPermissoes::all();
        $permissoes = $permissoes->pluck('nome','id');
        $permissoes->prepend('Selecione uma Permissão','');

        return view('permissao.paciente.index',compact( 'pacientes','permissoes'));
    }

    public function retornarProfissional(){
        $profissionais = User::whereNotNull('profissional_id')->get();
        $profissionais = $profissionais->pluck('name','id');
        $profissionais->prepend('Selecione um Profissional','');

        $permissoes = GrupoPermissoes::all();
        $permissoes = $permissoes->pluck('nome','id');
        $permissoes->prepend('Selecione uma Permissão','');
        return view('permissao.profissional.index',compact( 'profissionais','permissoes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $permissoes = Permissao::all();
        return view('permissao.create',['permissoes' => $permissoes]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PermissoesRequest $request)
    {
        //
        $grupo = new GrupoPermissoes([
            'nome' => $request->get('nome'),
            'descricao' => $request->get('descricao')
        ]);

        $grupo->save();

        $permissoes = Permissao::all();
        foreach ($permissoes as $permissao){
            if($request->has($permissao->nome)){
                $per_grupo = new RelacaoPermissoesGrupo([
                    'grupo_id' => $grupo->id,
                    'permissao_id' => $permissao->id
                ]);
                $per_grupo->save();
                unset($per_grupo);
            }
        }

        return redirect('/vida/permissao');
    }

    public function gravarPermissaoPaciente(Request $request){
        $user_id = $request->get('paciente_id');
        $grupo_id = $request->get('grupo_id');
        $p_g = PessoaGrupo::where('user_id',$user_id)->first();
        if(!is_null($p_g)){
            $p_g->grupo_id = $grupo_id;
            $p_g->save();
        }else{
            $grupo = new PessoaGrupo([
                'grupo_id' => $grupo_id,
                'user_id' => $user_id
            ]);
            $grupo->save();
        }

        return redirect('/vida/permissao');
    }

    public function gravarPermissaoProfissional(Request $request){
        $user_id = $request->get('profissional_id');
        $grupo_id = $request->get('grupo_id');
        $grupo = new PessoaGrupo([
            'grupo_id' => $grupo_id,
            'user_id' => $user_id
        ]);

        $grupo->save();
        return redirect('/vida/permissao');
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
        //
        return view('permissao.edit',[]);
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
