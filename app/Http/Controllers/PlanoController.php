<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Plano;
use App\Models\Plano_Valor;
use DebugBar;
use App\Models\Plano_Conta;
use Illuminate\Foundation\Auth\User;
use Illuminate\Support\Facades\Auth;

class PlanoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Retorna itens
        $items = Plano::latest('updated_at')->get();

        return view('planos.index', compact('items'));
    }

    /**
     * Histórico de Valores
     *
     * @return \Illuminate\Http\Response
     */
    public function historico($id)
    {
        $plano = Plano::withTrashed()->where('id', $id)->first();

        $items = Plano_Valor::withTrashed()
                                ->select('plano_valores.id', 'plano_valores.valor', 'plano_valores.adicional_dependente', 'plano_valores.usuario_cadastro', 'plano_valores.created_at', 'users.name')
                                ->where('plano_id', '=', $id)
                                ->join('users', 'users.id', '=', 'plano_valores.usuario_cadastro')
                                ->orderBy('plano_valores.id', 'desc')
                                ->get();

        return view('planos.historico', compact('plano', 'items'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // Popula lista com todos planos de contas e um em branco
        $plano_contas = Plano_Conta::where('tipo', '=', 'CR')->orderBy('classificacao', 'asc')->get();
        $plano_contas = $plano_contas->pluck('descricao', 'id');
        $plano_contas->prepend('Selecione uma conta', '');

        // Popula lista com todos usuários do tipo empresa e um em branco
        $empresas = User::where('empresa_id', '<>', null)->get();
        $empresas = $empresas->pluck('name', 'id');
        $empresas->prepend('Selecione uma empresa', '');

        return view('planos.create', compact('plano_contas', 'empresas'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, Plano::rules());

        // Request para Array
        $req = collect($request);

        // Formata valores para exibir corretamente
        $req['valor'] = str_replace(',', '.', str_replace('.', '', $req->get('valor')));
        $req['adicional_dependente'] = str_replace(',', '.', str_replace('.', '', $req->get('adicional_dependente')));

        // Informa usuário de cadastro
        $req->put('usuario_cadastro', Auth::id());

        $plano = Plano::create($req->all());    

        // Adiciona ao request o id do plano, para gravar histórico
        $req->put('plano_id', $plano->id);
        
        Plano_Valor::create($req->all());

        return redirect()->route(VIDA . '.planos.index')->withSuccess(trans('app.success_store'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $item = Plano::findOrFail($id);

        // Formata valores para exibir corretamente
        $item->valor = number_format($item->valor, 2);
        $item->adicional_dependente = number_format($item->adicional_dependente, 2);

        // Popula lista com todos planos de contas e um em branco
        $plano_contas = Plano_Conta::where('tipo', '=', 'CR')->orderBy('classificacao', 'asc')->get();
        $plano_contas = $plano_contas->pluck('descricao', 'id');
        $plano_contas->prepend('Selecione uma conta', '');

        // Popula lista com todos usuários do tipo empresa e um em branco
        $empresas = User::where('empresa_id', '<>', null)->get();
        $empresas = $empresas->pluck('name', 'id');
        $empresas->prepend('Selecione uma empresa', '');

        return view('planos.edit', compact('item', 'plano_contas', 'empresas'));
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
        $this->validate($request, Plano::rulesUpdate(true, $id));

        $item = Plano::findOrFail($id);

        // Formata valores numéricos para banco de dados
        $request['valor'] = str_replace(',', '.', str_replace('.', '', $request->get('valor')));
        $request['adicional_dependente'] = str_replace(',', '.', str_replace('.', '', $request->get('adicional_dependente')));

        // Verifica alteração DESCRIÇÃO
        if(($item->descricao != $request->get('descricao')) && !empty($request->get('descricao')))
            $item->descricao = $request->get('descricao');
            
        $valorAlterado = false;
        $req = collect($request);
        // Verifica alteração VALOR
        if(($item->valor != $request->get('valor')) && !empty($request->get('valor'))){
            // Atualizar VALOR
            $item->valor = $request->get('valor');

            // Atualização de histórico de preço
            $valorAlterado = true;
            $req->put('usuario_cadastro', Auth::id());
            $req->put('plano_id', $id);
        }

        // Verifica alteração ADICIONAL DEPENDENTE
        if(($item->adicional_dependente != $request->get('adicional_dependente')) && !empty($request->get('adicional_dependente'))){
            // Atualizar ADICIONAL DEPENDENTE
            $item->adicional_dependente = $request->get('adicional_dependente');

            // Atualização de histórico de preço
            if(!$valorAlterado){
                $valorAlterado = true;
                $req->put('usuario_cadastro', Auth::id());
                $req->put('plano_id', $id);
            }
        }

        // Verifica alteração DEPENDENTES
        if(($item->dependentes != $request->get('dependentes')) && !empty($request->get('dependentes')))
            $item->dependentes = $request->get('dependentes');

        // Verifica alteração ENTRADA
        if(($item->entrada != $request->get('entrada')) && !empty($request->get('entrada')))
            $item->entrada = $request->get('entrada');

        // Verifica alteração MESES CONTRATO
        if(($item->meses_contrato != $request->get('meses_contrato')) && !empty($request->get('meses_contrato')))
            $item->meses_contrato = $request->get('meses_contrato');

        // Verifica alteração PLANO DE CONTAS
        if(($item->plano_contas_id != $request->get('plano_contas_id')) && !empty($request->get('plano_contas_id')))
            $item->plano_contas_id = $request->get('plano_contas_id');

        // Verifica alteração EMPRESA
        if(($item->user_id != $request->get('user_id')) && !empty($request->get('user_id')))
            $item->user_id = $request->get('user_id');

        // Grava histórico de alteração, se houver
        if($valorAlterado)
            Plano_Valor::create($req->all());

        // Salva alterações
        $item->save();

        return redirect()->route(VIDA . '.planos.index')->withSuccess(trans('app.success_update'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // Soft delete Plano Valor
        Plano_Valor::where('plano_id', $id)->delete();

        // Soft delete Plano
        Plano::where('id', $id)->delete();

        return back()->withSuccess(trans('app.success_destroy')); 
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function desativados()
    {
        // Retorna planos desativados
        $items = Plano::onlyTrashed()->get();

        return view('planos.desativados', compact('items'));
    }

    /**
     * Restore specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function restore($id)
    {
        // Restaura Plano Valor
        Plano_Valor::where('plano_id', $id)->restore();

        // Restaura Plano
        Plano::where('id', $id)->restore();

        return back()->withSuccess(trans('app.success_restore')); 
    }

}
