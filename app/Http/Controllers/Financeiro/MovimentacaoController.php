<?php

namespace App\Http\Controllers\Financeiro;


use App\Http\Requests\MovimentacaoRequest;
use App\Models\Financeiro\Movimentacao;
use App\Models\Financeiro\Parcela;
use App\Models\Permissao;
use App\Repositorio\MovimentacaoRepositorio;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class MovimentacaoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return Movimentacao::all();
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
    public function arrayToObject($array)
    {
        $object = new \stdClass();
        foreach ($array as $key => $value)
        {
            $object->$key = $value;
        }
        return $object;
    }

    public function getmovimentacao(Request $request)
    {
        $dados = $request->get('data');
        $fk_financ = (int) $dados['fk_financeiro_mov'];


        $finan_mov = Movimentacao::find($fk_financ);
     //   $finan_parc = Parcela::where('movimentacao_id', $finan_mov['id'])->get();

        //$ret = [];
        $ret = collect($finan_mov);
        //$ret['parcelas'] = collect($finan_parc);


        return $ret;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store($params)// array com informações
    {
        if(Gate::denies('checarPapeis', Permissao::PERMISSAO_ID[Permissao::FINANCEIRO])){
            throw new NoContentException(app('translator')->trans('erro.pesssoa_permissao'), Response::HTTP_CONFLICT);
        }
     //   $data = $request->get('data');
        // $data['movimentacao_tipo'];
        $tipo = (int) $params['movimentacao_tipo'];

        if(is_null($tipo)){
            return Redirect::back()->withErrors(['msg', 'Transação sem tipo']);
        }

        $movimentacao = new MovimentacaoRepositorio();
        $data = $this->arrayToObject($params);
        $retorno = $movimentacao->gerarMovimentacao($data,$tipo);

        return $retorno;
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
        $ret = Movimentacao::with('parcelas')->where('id',$id)->get();
        $ret = $ret[0];
        $ret = collect($ret);
        return $ret;
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
