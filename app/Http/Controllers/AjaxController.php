<?php

namespace App\Http\Controllers;

use App\Models\Financeiro\Movimentacao;
use App\Models\Financeiro\MovimentacaoTipo;
use App\Models\Financeiro\Pagamento;
use App\Models\Financeiro\Parcela;
use App\Models\Formas_Pagamento;
use App\Models\GrupoPermissoes;
use App\Models\Permissao;
use App\Models\PessoaGrupo;
use App\Models\Plano;
use App\Models\RelacaoPermissoesGrupo;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AjaxController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        $nome = $request->get('nome');
        $nome = trim($nome);
        $valor = User::where('name','LIKE', '%'.$nome.'%')->orWhere('cnpjcpf','LIKE',$nome)->get()->toArray();

        return response()->json(array(
            'status' => 'sucesso',
            'valors' => $valor
        ),200);
    }

    public function addDependente(Request $request){
        if($request->has('id_dependente') && $request->has('id_titular')){
            $dependente = User::find($request->get('id_dependente'));
            $titular = User::find($request->get('id_titular'));
            $all_dependentes = User::where('titular_id',$request->get('id_titular'))->count();
            if(!is_null($dependente) && !is_null($titular)){
                $dependente->titular_id = $request->get('id_titular');
                $dependente->nim = $titular->nim;
                $dependente->ordem = $all_dependentes + 1;
                $dependente->save();
                return response()->json(array(
                    'status' => 'sucesso',
                ),200);
            }
        }
        return response()->json(array(
            'status' => 'sucesso',
        ),200);
    }

    public function retornarEmpresa(Request $request){
        $nome = $request->get('empresa');
        $valor = User::whereNotNull('empresa_id')
            ->whereNull('profissional_id')
            ->where('name','LIKE', '%'.$nome.'%')
            ->orWhere('cnpjcpf','LIKE','%'.$nome.'%')
            ->get()
            ->toArray();

        return response()->json(array(
            'status' => 'sucesso',
            'valors' => $valor
        ),200);
    }

    public function estornarParcela(Request $request){
        $retorno = "";
        if($request->has('id')){
            $f_c = new FinanceiroController();
            $retorno = $f_c->estornarParcela($request->get('id'));
        }
        return response()->json(array(
            'status' => 'sucesso',
            'valors' => collect($retorno)
        ),200);
    }

    public function pagarParcela(Request $request){
        $retorno = "";
        if($request->has('id')){
            $parcela = Parcela::find($request->get('id'));
            if($request->has('forma_pagamento')){
                $parcela->fk_forma_pagamento = $request->get('forma_pagamento');
                $parcela->save();
            }
            $arr =[
                'parcela_id' => $parcela->id
            ];
            $f_c = new FinanceiroController();
            $retorno = $f_c->quitarParcela($arr);
        }
        return response()->json(array(
            'status' => 'sucesso',
            'valors' => collect($retorno)
        ),200);
    }

    public function retornarMovimentacao($id){
        $movimentacao = Movimentacao::with('parcelas','pessoa.user','movimentacao.parcelas')->where('id',$id)->first();
        return response()->json(array(
            'status' => 'sucesso',
            'valors' => collect($movimentacao)
        ),200);
    }

    public function retornarNumeroParcelas($id){
        $fpg = Formas_Pagamento::find($id);
        $valor =[];
        $valor[0] = $fpg->n_parcelas;
        $valor[1] = $fpg->taxa;
        return response()->json(array(
            'status' => 'sucesso',
            'valors' => $valor
        ),200);
    }

    public function retornarValorParcialVenda(Request $request, $id){
        $plano = Plano::find($id);
        $user_id = $request->get('user_id');
        $n_dep = User::where('titular_id',$user_id)->count();
        $excedente = $n_dep - $plano->dependentes;
        $val_dep = is_null($plano->adicional_dependente) ? 0 : $plano->adicional_dependente * (($excedente < 0) ? 0 : $excedente);

        $valor[0] = $plano->valor;
        $valor[1] = $n_dep;
        $valor[2] = $plano->valor + $val_dep;
        $valor[3] = $plano->meses_contrato;
        $valor[4] = $plano->entrada * $plano->valor;
        return response()->json(array(
            'status' => 'sucesso',
            'valors' => $valor
        ),200);
    }

    public function retornarParcela($id){
        $parcela = Parcela::with('movimentacao.pessoa.user')->where('id',$id)->first();

        $valor[0] = $parcela->movimentacao->pessoa->user->name;
        $valor[1] = $parcela->valor;
        $valor[2] = $parcela->fk_forma_pagamento;

        return response()->json(array(
            'status' => 'sucesso',
            'valors' => $valor
        ),200);
    }

    public function buscarPermissao($id){
        $valor =[];
        $pes_grupo = PessoaGrupo::where('user_id',$id)->first();
        if(!is_null($pes_grupo)){
            $grupo = GrupoPermissoes::find($pes_grupo->grupo_id);
            $relacao = RelacaoPermissoesGrupo::where('grupo_id',$grupo->id)->get();
            $arr =[];
            foreach ($relacao as $key=>$r){
                $permissao = Permissao::find($r->permissao_id);
                $arr[$key] = Permissao::PERMISSAO[$permissao->valor];
            }

            $valor[0] = $grupo->nome;
            $valor[1] = $grupo->descricao;
            $valor[2] = $arr;
        }


        return response()->json(array(
            'status' => 'sucesso',
            'valors' => $valor
        ),200);
    }
    public function retornarGraficoMensal(){
        $past = Carbon::now()->subMonth(6);//->format('Y-m-d');
        $arrEntrada = [];
        $arrSaida = [];
        $arrBalanco = [];
        $meses = [];
        $vet_parcelas = [];
        $vet_mov = [];

        $mesesPt = ['','Janeiro', 'Fevereiro','Março', 'Abril','Maio', 'Junho','Julho','Agosto','Setembro','Outubro','Novembro','Dezembro'];
        for($i=0;$i<7;$i++){

            $past = $past->addMonth($i>0? 1 : 0);
            $meses[$i] = $mesesPt[$past->month];
            $fim = clone $past->endOfMonth();
            $inicio = clone $past->startOfMonth();

            $pagamentos = Pagamento::where('data','>',$inicio)->where('data','<',$fim)->get();
            $accEntrada=0;
            foreach ($pagamentos as $pagamento){
                $accEntrada += $pagamento->valor;
            }
            $arrEntrada[$i] = $accEntrada;

            $saidas = Movimentacao::where('tipo_id',MovimentacaoTipo::TIPO_ID[MovimentacaoTipo::CREDITO])
                                        ->where('sentido','like','C')
                                        ->where('created_at','>', $inicio)
                                        ->where('created_at','<', $fim)
                                        ->get();
            $accSaida =0;
            foreach ($saidas as $saida) {
                $accSaida +=$saida->valor_total;
            }
            $arrSaida[$i] =  $accSaida;

            $arrBalanco[$i] = $accEntrada - $accSaida;

            $parcelas_atrasadas = Parcela::where('status','=',Parcela::STATUS_ID[Parcela::ATRASADA])
                                        ->where('data_vencimento','>',$inicio)
                                        ->where('data_vencimento','<',$fim)
                                        ->get();
            $accAtrasada =0;
            foreach ($parcelas_atrasadas as $atrasada){
                $accAtrasada+= $atrasada->valor;
            }
            $vet_parcelas[0][$i] =$accAtrasada;

            $parcelas_pagas = Parcela::where('status','=',Parcela::STATUS_ID[Parcela::PAGA])
                ->where('data_vencimento','>',$inicio)
                ->where('data_vencimento','<',$fim)
                ->get();
            $accPaga =0;
            foreach ($parcelas_pagas as $paga){
                $accPaga+= $paga->valor;
            }

            $vet_parcelas[1][$i] = $accPaga;

            $vet_mov[0][$i] = Movimentacao::where('created_at','>',$inicio)->where('created_at','<',$fim)->count();
            $vet_mov[1][$i] = Movimentacao::where('status','=',Movimentacao::STATUS_ID[Movimentacao::QUITADA])->where('updated_at','>',$inicio)->where('updated_at','<',$fim)->count();
            $vet_mov[2][$i] = Movimentacao::where('status','=',Movimentacao::STATUS_ID[Movimentacao::PARCIALMENTE_PAGA])->where('updated_at','>',$inicio)->where('updated_at','<',$fim)->count();

        }
        return $arr=[$arrEntrada,$arrSaida,$arrBalanco,$meses,$vet_parcelas,$vet_mov];

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
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function deletarMovimentacao(Request $request)
    {
        $id = $request->get('id');
        $mov = Movimentacao::find($id);
        $par = Parcela::where('movimentacao_id', $mov->id)->get();

        foreach($par as $p){
            $aux = Parcela::find($p->id);
            if(!is_null($aux)){
                if(!is_null($aux->pagamento_id)){
                    $pag2 = Pagamento::find($aux->pagamento_id);
                    $mov2 = Movimentacao::find($pag2->movimentacao_id);
                    $par2 = Parcela::where('movimentacao_id', $mov->id)->get();

                    foreach($par2 as $p2){
                        $aux2 = Parcela::find($p2->id);
                        $aux2->delete();
                    }
                    $mov2->delete();
                    $pag2->delete();
                }
            }
            $aux->delete();
        }

        $mov->delete();
        return 1;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function deletarParcela(Request $request)
    {
        $id = $request->get('id');
        $parcela = Parcela::find($id);
        if(!is_null($parcela)){
            if(!is_null($parcela->pagamento_id)){
                $pag = Pagamento::find($parcela->pagamento_id);
                $mov = Movimentacao::find($pag->movimentacao_id);
                $par = Parcela::where('movimentacao_id', $mov->id)->get();

                foreach($par as $p){
                    $aux = Parcela::find($p->id);
                    $aux->delete();
                }
                $mov->delete();
                $pag->delete();
            }

        }

        $parcela->delete();
        return 1;
    }
}
