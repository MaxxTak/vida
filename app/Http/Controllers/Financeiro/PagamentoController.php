<?php

namespace App\Http\Controllers\Financeiro;

use App\Models\Financeiro\Movimentacao;
use App\Models\Financeiro\MovimentacaoTipo;
use App\Models\Financeiro\FormaPagamento;
use App\Models\Financeiro\Pagamento;
use App\Models\Financeiro\Parcela;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Redirect;

class PagamentoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return Pagamento::all();
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

    public static function pagamentoCredito($request, $valor=0, $taxa_cartao=0, Movimentacao $movimentacao)
    {
        $pagamento = new Pagamento([
            'valor' => $valor,
            'data' => Carbon::now(),
            'movimentacao_id' => $movimentacao->id,
            'taxa_cartao' => $taxa_cartao
        ]);
        $pagamento->save();
        $pagamento = Pagamento::find($pagamento->id);
     //   $formaPagamento = new FormaPagamentoController();
     //   $formaPagamento->gerarFormaCredito($request, $pagamento);

        return $pagamento;
    }

    public function gerarPagamentoParcelas($request, $movimentacao , $servico = null)
    {
        $parcelas = $request->parcelas;

        $valor = $request->valor;
        $mid = $movimentacao->id;


        $pagamento = new Pagamento([
            'valor' => $valor,
            'data' => Carbon::now(),
            'movimentacao_id' => $mid,
            'taxa_cartao' => isset($request->taxa_cartao)? (float) $request->taxa_cartao : 0
        ]);
        $pagamento->save();

        $formaPagamento = new FormaPagamentoController();
        $formaPagamento->gerarFormaPagamento($pagamento,$parcelas);

        $parcela = new ParcelaController();
        $parcela->pagarParcela($parcelas, $valor, $pagamento, $servico);

        return $pagamento;
    }

    public function pgt(Request $request)
    {
        $dados = $request->get('data');
        $parcelas = $dados['parcelas'];

        $idmov = (int) $dados['mov'];
        if(is_null($idmov)){
            return Redirect::back()->withErrors(['msg', 'ID nulo da movimentação']);
        }

        $movim = Movimentacao::where('id', $idmov)->first();
        if(is_null($movim)){
            return Redirect::back()->withErrors(['msg', 'Fail movimentação']);
        }

        $mov = new Movimentacao([
            'tipo_id' => MovimentacaoTipo::TIPO_ID[MovimentacaoTipo::PAGAMENTO],
            'pessoa_id' => $movim->pessoa_id,
            'descricao' => $movim->descricao,
            'valor' => $movim->valor,
            'descontos' => isset($movim->descontos) ? $movim->descontos : null,
            'status' => Movimentacao::STATUS_ID[Movimentacao::ABERTA]
        ]);
        $mov->save();

        $mov->valor_total = $movim->valor_total;
        $mov->sentido = 'C';
        $mov->save();

        $retorno = $this->gerarPagamentoParcelas($dados, $mov);

        return $retorno;
    }

    public function pagarServico(){

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
        return Redirect::back()->withErrors(['msg', 'Não permitido']);
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
        return Pagamento::find($id);
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
