<?php

namespace App\Http\Controllers\Financeiro;

use App\Models\Financeiro\Estorno;
use App\Models\Financeiro\Movimentacao;
use App\Models\Financeiro\MovimentacaoTipo;
use App\Models\Financeiro\MovimentacoesEstornadas;
use App\Models\Financeiro\Pagamento;
use App\Models\Financeiro\Parcela;
use App\Models\Financeiro\ParcelaPagamento;
use App\Models\Financeiro\Pessoa;
use App\Repositorio\MovimentacaoRepositorio;
use App\Repositorio\ParcelaRepositorio;
use Carbon\Carbon;
use Illuminate\Http\Request;

class EstornoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return Estorno::all();
    }

    public function estornarParcelaPagamento( $parcela,  $m_e, $parcial=null){
        $parcelas_pagamentos = ParcelaPagamento::where('parcela_id',$parcela->id)->get();

        if(count($parcelas_pagamentos)>0){
            $cc = new ContaCorrenteController();
            foreach($parcelas_pagamentos as $pagamento){
                $pg= Pagamento::find($pagamento->pagamento_id);
                if(!is_null($pg)){
                    $estorno = new Estorno([
                        'pagamento_id'=> $pg->id ,//fk que estornou
                        'movimentacao_id_estornada' => $m_e->id,//fk para estornada (sempre gera movimentacao)
                        'pessoa_id'=>$m_e->pessoa_id,
                        'valor'=> is_null($parcial) ? $parcela->valor : $parcela->valor_parcial,
                        'data_estorno'=>Carbon::now()
                    ]);

                    $estorno->save();

                    $cc->gerarDebito($m_e,is_null($parcial) ? $parcela->valor : $parcela->valor_parcial);
                }

            }
        }


    }

    public function estornarGerarCredito($request){
        $conta = new ContaCorrenteController();
        $retorno = $conta->gerarCreditoEstorno($request);
    }

    public function estornarGerarDebito($request){
        $conta = new ContaCorrenteController();
        $retorno = $conta->gerarDebitoEstorno($request);
    }

    public function estornarMovimentacao($request, Movimentacao $movimentacao, Pessoa $pessoa){
        $movimentacao_estornada =null;

        $movimentacao_estornada = Movimentacao::where('pessoa_id',$pessoa->id)->where('id',$request->movimentacao_id)->first();

        if(!is_null($movimentacao_estornada)){
            $parc = Parcela::where('movimentacao_id',$request->movimentacao_id)->count();

            $mov_e = new MovimentacoesEstornadas([
                'movimentacao_id'=>$movimentacao->id,
                'movimentacao_id_estornada' => $movimentacao_estornada->id,
                'motivo_estorno'=> "",
                'pessoa_id'=>$pessoa->id,
                'sentido_cc'=>$request->movimentacao_sentido,
                'num_parcelas'=> $parc,
                'data_estorno'=> Carbon::now()
            ]);

            $mov_e->save();


            $mov = new MovimentacaoRepositorio();
            $mov->estornarMovimentacao($movimentacao_estornada,$mov_e);

        }
       return $movimentacao_estornada;

    }
    public function estornarPagamento($request,$mov){
        $pg =null;
        if(isset($request->pagamento_id))
            $pg= Pagamento::with('movimentacao')->where('id',$request->pagamento_id)->first();
        if(!is_null($pg))
            $parcelas_pagamentos = ParcelaPagamento::where('pagamentos_id',$pg->id)->get();
        else
            $parcelas_pagamentos=[];
        $flag =0;

        if(count($parcelas_pagamentos) > 0){
            $cc = new ContaCorrenteController();
            foreach($parcelas_pagamentos as $parcela){
                $parcela_aux = Parcela::find($parcela->parcela_id);
                if($parcela_aux->status == Parcela::STATUS_ID[Parcela::PAGA]){
                    $estorno = new Estorno([
                        'pagamentos_id'=> $pg->id ,//fk que estornou
                        'movimentacao_id' => $mov->id,//fk para estornada (sempre gera movimentacao)
                        'motivo_estorno' => "Estorno Pagamento",
                        'pessoa_id'=>$mov->pessoa_id,
                        'valor'=> is_null($parcela_aux->valor_parcial) ? $parcela_aux->valor : $parcela_aux->valor_parcial,
                        'data_estorno'=>Carbon::now()
                    ]);

                    $estorno->save();

                    if(!is_null($parcela_aux)){
                        $parcela_aux->status = Parcela::STATUS_ID[Parcela::ESTORNADA];

                        $parcela_aux->save();

                        $parcela_nova = new Parcela([
                            'movimentacao_id' => $parcela_aux->movimentacao_id,
                            'valor' => $parcela_aux->valor,
                            'taxa'=> $parcela_aux->taxa,
                            'data_vencimento'=>$parcela_aux->data_vencimento,
                            'status' => Parcela::STATUS_ID[Parcela::ABERTA]
                        ]);

                        $parcela_nova->save();
                        $parcela_nova->parcela_mae_id = $parcela_aux->id;
                        $parcela_nova->fk_forma_pagamento = $parcela_aux->fk_forma_pagamento;
                        $parcela_nova->save();
                        $mov = Movimentacao::find($parcela_aux->movimentacao_id);
                        $mov->status = Movimentacao::STATUS_ID[Movimentacao::ABERTA];
                        $mov->save();
                    }


                    $cc->gerarDebito($mov, $parcela->valor);
                }else{//Cancela parcela
                    //$flag = 1;
                }

            }

        }

        if((count($parcelas_pagamentos)==0)||($flag!=0)){//Cancela parcela
            $parcelas = $request->parcelas;
            foreach ($parcelas as $parcela){
                $p_aux = Parcela::find($parcela['id']);
                $p_aux->status = Parcela::STATUS_ID[Parcela::CANCELADA];
                $p_aux->save();
            }
        }

        return $parcelas_pagamentos;

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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        return Estorno::find($id);
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
