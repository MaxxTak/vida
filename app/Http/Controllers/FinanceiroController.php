<?php

namespace App\Http\Controllers;

use App\Models\Aviso;
use App\Models\Financeiro\ContaCorrente;
use App\Models\Financeiro\Movimentacao;
use App\Models\Financeiro\MovimentacaoTipo;
use App\Models\Financeiro\Pagamento;
use App\Models\Financeiro\Parcela;
use App\Models\Financeiro\ParcelaPagamento;
use App\Models\Formas_Pagamento;
use App\Models\Plano;
use App\Models\PlanoPessoa;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class FinanceiroController extends Controller
{
    public function retornarMovimentacoes(){
        $mov = Movimentacao::with('pessoa.user')->where('sentido','like','D')->whereNull('movimentacao_id')->get();
        return view('financeiro.movimentacoes.movimentacoes',['movimentacoes'=>$mov]);
    }

    public function retornarParcelas(){
        $par = Parcela::with('movimentacao.pessoa.user','forma')->get();
        $fpg = Formas_Pagamento::all();
        $fpg = $fpg->pluck('descricao','id');
        $fpg->prepend('Selecione uma forma de pagamento','');
        return view('financeiro.movimentacoes.parcelas',['parcelas'=>$par, 'fpg'=> $fpg]);
    }

    public function retornarAcerto(){
        $cc = ContaCorrente::with('pessoa.user')->where('saldo','>',0)->get();
        return view('financeiro.acerto.acerto',['contas'=>$cc]);
    }

    public function retornarExtrato(Request $request){
        $pro_id = $request->get('pr_id');
        $mov = Movimentacao::with(['guia'=>function ($q) use($pro_id){
            $q->where('profissional_id',$pro_id);
        }])
            ->with('pessoa.user')
            ->whereNotNull('movimentacao_guia_id')
            ->get();

        return view('financeiro.acerto.extrato',['movs'=>$mov]);
    }

    public function retornarAgendar(){
        return view('financeiro.agendar',[]);
    }

    public function retornarBaixa(){
        $past = Carbon::now();//->format('Y-m-d');
        $fim = clone $past->endOfMonth();
        $inicio = clone $past->startOfMonth();

        $pagamentos = Pagamento::where('data','>',$inicio)->where('data','<',$fim)->get();
        $parcelas = Parcela::where('status','=', Parcela::STATUS_ID[Parcela::ATRASADA])->where('data_vencimento','>',$inicio)->where('data_vencimento','<',$fim)->get();
        $parcelas_abertas = Parcela::where('status','=', Parcela::STATUS_ID[Parcela::ABERTA])->where('data_vencimento','>',$inicio)->where('data_vencimento','<',$fim)->get();

        $arr = [];
        foreach ($parcelas_abertas as $key=>$pa){
            $arr[$key] = $pa->movimentacao_id;
        }

        $mov = Movimentacao::with('pessoa.user')
                    ->where('created_at','>',$inicio)->where('created_at','<',$fim)
                    ->where('sentido','=','C')
                    ->where('status','<>',Movimentacao::STATUS_ID[Movimentacao::QUITADA])
                    ->orWhereIn('id',$arr)
                    ->get();

        foreach ($mov as $m){
            if($m->sentido == 'C' && $m->tipo_id == 4){
                $pag = Pagamento::where('movimentacao_id',$m->id)->first();
                $pp = ParcelaPagamento::where('pagamentos_id',$pag->id)->first();
                $par = Parcela::where('id',$pp->parcela_id)->first();
                $fpg = Formas_Pagamento::where('id',$par->fk_forma_pagamento)->first();
                $m->fpg = $fpg->descricao;
            }
        }

        return view('financeiro.baixa',['pagamentos'=> $pagamentos,'parcelas'=>$parcelas,'parcelas_abertas'=> $parcelas_abertas ,'baixas'=>$mov]);
    }

    public function retornarVenda(Request $request){
        $user = null;
        if($request->has('user_id')){
            $pessoas = User::where('id',$request->get('user_id'))->get();
            $pessoas = $pessoas->pluck('name', 'id');
            $user = $request->get('user_id');
        }else{
            $pessoas = User::where('profissional_id', '<>', null)
                ->orWhere('empresa_id', '<>', null)
                ->orWhere('paciente_id', '<>', null)
                ->orderBy('name', 'asc')
                ->get();
            $pessoas = $pessoas->pluck('name', 'id');
            $pessoas->prepend('Selecione uma pessoa', '');
        }

        $planos = Plano::all();
        foreach ($planos as $plano){
            $plano->descricao = strtoupper($plano->descricao) . " Valor: R$" . $plano->valor." (mensal)" ." Dependentes: ". $plano->dependentes ." +R$". $plano->adicional_dependente ." (para cada excedente)" . " Meses: ". $plano->meses_contrato;
        }
        $planos = $planos->pluck('descricao','id');
        $planos->prepend('Selecione um plano','');

        $fpg = Formas_Pagamento::all();
        $fpg = $fpg->pluck('descricao','id');
        $fpg->prepend('Selecione uma forma de pagamento','');

        return view('financeiro.venda', compact( 'pessoas','planos','fpg','user'));
    }

    public function retornarRetroativo(Request $request){
        if($request->has('user_id')){
            $pessoas = User::where('id',$request->get('user_id'))->get();
            $pessoas = $pessoas->pluck('name', 'id');
        }else{
            $pessoas = User::where('profissional_id', '<>', null)
                ->orWhere('empresa_id', '<>', null)
                ->orWhere('paciente_id', '<>', null)
                ->orderBy('name', 'asc')
                ->get();
            $pessoas = $pessoas->pluck('name', 'id');
            $pessoas->prepend('Selecione uma pessoa', '');
        }

        $planos = Plano::all();
        foreach ($planos as $plano){
            $plano->descricao = strtoupper($plano->descricao) . " Valor: R$" . $plano->valor." (mensal)" ." Dependente: ". $plano->dependentes ." +R$". $plano->adicional_dependente ." (para cada excedente)" . " Meses: ". $plano->meses_contrato;
        }
        $planos = $planos->pluck('descricao','id');
        $planos->prepend('Selecione um plano','');

        $fpg = Formas_Pagamento::all();
        $fpg = $fpg->pluck('descricao','id');
        $fpg->prepend('Selecione uma forma de pagamento','');

        return view('financeiro.movimentacoes.retroativo', compact( 'pessoas','planos','fpg'));
    }

    public function confirmarVenda(Request $request){
        $user = User::find($request->get('user_id'));
        $dependentes = User::where('titular_id', $user->id)->get();
        $plano = Plano::find($request->get('plano_id'));
        $fpg = Formas_Pagamento::find($request->get('forma_pagamento_id'));
        $n_parcelas = is_numeric($request->get('n_parcelas')) ? $request->get('n_parcelas') : 1;

        $excedente = count($dependentes) - $plano->dependentes;
        $parcial = $plano->valor * $plano->entrada;
        $valor_parcela = $parcial / $n_parcelas;

        $data_pagamento = $request->has("data_pagamento") ? $request->get("data_pagamento") : null;

        $total = $parcial + ($parcial * (is_null($fpg) ? 0 : $fpg->taxa / 100))  + (($excedente < 0) ? 0 : $excedente * $plano->adicional_dependente);
        return view('financeiro.confirmar', compact('user','plano','fpg','n_parcelas','dependentes','valor_parcela','total','data_pagamento'));
    }

    public function salvarVendaPlano(Request $request){

        \DB::beginTransaction();
        $flag = 0;
        try{
            $plano = Plano::find($request->get('plano_id'));
            $fpg = Formas_Pagamento::find($request->get('forma_pagamento'));

            $n = $request->get('n_parcelas');
            $parcelas =[];
            $t = Carbon::now();
            $t2 = clone($t);
//            $day = $request->has("data_pagamento")? ((!is_null($request->get("data_pagamento")) && ($request->get("data_pagamento") > 0))? $request->get("data_pagamento") : $t->day) : $t->day;
//            $time = Carbon::createFromDate($t->year, $t->month, $day);
            for($i=0; $i < $n;$i++){
                $aux = [];
                $aux['valor'] = ($plano->valor * $plano->entrada)/$n;//$p['valor'];
                //data_pagamento
//                if($i === 0)
                    $aux['vencimento'] = Carbon::now()->addMonth($i);//$p['data'];
//                else
//                    $aux['vencimento'] = Carbon::createFromDate($t->year, $t->month, $day)->addMonth($i);//$p['data'];

                $aux['fk_fpg_codigo'] = $fpg->id;//$parc['fk_fpg_codigo'];
                $aux['forma_pagamento'] = $fpg->id;//$parc['fk_fpg_codigo'];
                $aux['taxa'] = $fpg->taxa;//is_null($ptx) ? 0 : $ptx->ptx_valor_taxa ;
                $parcelas[$i] = $aux;
            }

            $ret = $this->debitarPlano($request->get('user_id'), $request->has('desconto') ? $request->get('desconto') : 0, ($plano->valor * $plano->entrada), "Debitar Entrada", $parcelas);

            $mov_id = $ret->id;
            $ret = $this->gerarPagamentoDebito($request->get('user_id'), $request->has('desconto') ? $request->get('desconto') : 0, (($plano->valor * $plano->entrada)/$n), "Pagamento Movimentação Entrada", $mov_id);
            $plano_pessoa = new PlanoPessoa([
                'user_id' => $request->get('user_id'),
                'plano_id' => $request->get('plano_id'),
                'status' => 1
            ]);
            $plano_pessoa->save();


//            $day2 = $request->has("data_pagamento")? ((!is_null($request->get("data_pagamento")) && ($request->get("data_pagamento") > 0))? $request->get("data_pagamento") : $t2->day) : $t2->day;

//            $time_par = Carbon::createFromDate($t2->year, $t2->month, $day2);
//dd(Carbon::createFromFormat('Y-m-d', $request->get('data_pagamento')));
            $n1 = (isset($plano->meses_contrato)&&($plano->meses_contrato > 0)) ? $plano->meses_contrato : 1;
            $parcelas =[];
            for($i=1; $i <= $n1;$i++){
                $aux = [];
                $aux['valor'] = $plano->valor ;//$p['valor'];
                $aux['vencimento'] = $request->has("data_pagamento")? Carbon::createFromFormat('Y-m-d', $request->get('data_pagamento'))->addMonth($i) : Carbon::now()->addMonth($i);//$p['data'];
                $aux['fk_fpg_codigo'] = $fpg->id;//$parc['fk_fpg_codigo'];
                $aux['forma_pagamento'] = $fpg->id;//$parc['fk_fpg_codigo'];
                $aux['taxa'] = 0;//is_null($ptx) ? 0 : $ptx->ptx_valor_taxa ;
                $parcelas[$i] = $aux;
            }
            $ret = $this->debitarPlano($request->get('user_id'), $request->has('desconto') ? $request->get('desconto') : 0, $plano->valor, "Debitar Mensalidade", $parcelas);
            $mov = Movimentacao::find($ret->id);
            $mov->movimentacao_id = $mov_id;
            $mov->save();
            \DB::commit();
//            \DB::rollBack();
            $flag=1;
        }catch (\Exception $exception){
            dd($exception);
        }
        if($flag)
            return redirect('vida/movimentacoes')->withSuccess(trans('app.success_store'));
        else
            return redirect('vida/movimentacoes')->withErrors(trans('app.error_store'));
    }

    public function salvarRetroativa(Request $request){

        \DB::beginTransaction();
        $flag = 0;
        try{
            $plano = Plano::find($request->get('plano_id'));
            $fpg = Formas_Pagamento::find($request->get('forma_pagamento_id'));

            $n = $request->get('n_parcelas');
            $n_pagas = $request->get('parcelas_pagas');
            $parcelas =[];
            $valor = 0;
            for($i=0; $i < $n;$i++){
                $aux = [];
                $valor +=$request->get('valor_'.$i);
                $aux['valor'] = $request->get('valor_'.$i);//$p['valor'];
                $aux['vencimento'] = $request->get('parcela_'.$i);//$p['data'];
                $aux['fk_fpg_codigo'] = $fpg->id;//$parc['fk_fpg_codigo'];
                $aux['forma_pagamento'] = $fpg->id;//$parc['fk_fpg_codigo'];
                $aux['taxa'] = $fpg->taxa;//is_null($ptx) ? 0 : $ptx->ptx_valor_taxa ;
                $parcelas[$i] = $aux;
            }

            $ret = $this->debitarPlano($request->get('user_id'), $request->has('desconto') ? $request->get('desconto') : 0, $valor, "Venda Retroativa: parcelas já quitadas=".$n_pagas." novas parcelas=".$n, $parcelas);

            $mov_id = $ret->id;
            $plano_pessoa = new PlanoPessoa([
                'user_id' => $request->get('user_id'),
                'plano_id' => $request->get('plano_id'),
                'status' => 1
            ]);
            $plano_pessoa->save();

      //      $mov = Movimentacao::find($ret->id);
      //      $mov->movimentacao_id = $mov_id;
      //      $mov->save();
            \DB::commit();
//            \DB::rollBack();
            $flag=1;
        }catch (\Exception $exception){
            \DB::rollBack();
        }
        if($flag === 1){
            return redirect('vida/movimentacoes')->withSuccess(trans('app.success_store'));
        }
         else{
             return redirect('vida/movimentacoes')->withErrors(trans('app.error_store'));
         }

    }

    public function quitarParcela($request){
        $retorno ="";
        if(isset($request['parcela_id'])){
            $par = Parcela::with('movimentacao.pessoa.user')->where('id',$request['parcela_id'])->first();
            $retorno = $this->pagarParcela($par->movimentacao->pessoa->user->id, isset($request['desconto']) ? $request['desconto'] : 0,$par->valor, "pagamento parcela", $par->id );
        }
        return $retorno;
    }

    public function quitarMovimentacao(Request $request){
        if($request->has('movimentacao_id')){
            $mov = Movimentacao::with('pessoa.user')->where('id',$request->get('movimentacao_id'))->first();
            $this->pagarParcela($mov->pessoa->user->id, $request->has('desconto') ? $request->get('desconto') : 0,$mov->valor, "pagamento movimentacao", $mov->id );
        }
    }

    public function debitarProduto($paciente_id, $desconto, $valor, $descricao, $parcelas){
       return $this->store(MovimentacaoTipo::TIPO_ID[MovimentacaoTipo::PRODUTO], 'D', $paciente_id, $desconto, $valor, $descricao, $parcelas);
    }

    public function debitarPlano($paciente_id, $desconto, $valor, $descricao, $parcelas){
        return $this->store(MovimentacaoTipo::TIPO_ID[MovimentacaoTipo::RECORRENTE], 'D', $paciente_id, $desconto, $valor, $descricao, $parcelas);
    }

    public function pagarProduto($paciente_id, $desconto, $valor, $descricao, $parcelas){
        return $this->store(MovimentacaoTipo::TIPO_ID[MovimentacaoTipo::SERVICO], 'C', $paciente_id, $desconto, $valor, $descricao, $parcelas);
    }

    public function pagarPlano($paciente_id, $desconto, $valor, $descricao, $parcelas){
        return $this->store(MovimentacaoTipo::TIPO_ID[MovimentacaoTipo::SERVICO], 'C', $paciente_id, $desconto, $valor, $descricao, $parcelas);
    }

    public function debitarGuia($paciente_id, $desconto, $valor, $descricao, $parcelas, $guia_id){
        $ret = $this->store(MovimentacaoTipo::TIPO_ID[MovimentacaoTipo::RECORRENTE], 'D', $paciente_id, $desconto, $valor, $descricao, $parcelas);
        if(!is_null($ret)){
            $mov = Movimentacao::find($ret->id);
            $mov->movimentacao_guia_id = $guia_id;
            $mov->save();
        }
        return $ret;
    }


    public function gerarCredito($paciente_id,$desconto,$valor,$descricao,$guia_id){
        $ret = $this->store(MovimentacaoTipo::TIPO_ID[MovimentacaoTipo::CREDITO], 'C', $paciente_id, $desconto, $valor, $descricao);
        if(!is_null($ret)){
            $mov = Movimentacao::find($ret->id);
            $mov->movimentacao_guia_id = $guia_id;
            $mov->save();
        }
        return $ret;
    }


    private function gerarParcelas($parcelas_aux){
        $parcelas =[];
        foreach ($parcelas_aux as $key=>$parcela){
            $aux = [];
            $aux['codigo'] = $parcela->id;
            $aux['valor'] = $parcela->valor;//$p['valor'];
            $aux['vencimento'] = $parcela->data_vencimento;
            $aux['forma_pagamento'] = $parcela->fk_forma_pagamento;
            $aux['taxa'] = $parcela->taxa;
            $parcelas[$key] = $aux;
        }
        return $parcelas;
    }

    public function pagarParcela($paciente_id, $desconto, $valor, $descricao, $parcela_id){
        $parcelas_aux = Parcela::where('id',$parcela_id)->get();
        $parcelas = $this->gerarParcelas($parcelas_aux);

        $retorno = $this->pagarProduto($paciente_id, $desconto, $valor, $descricao, $parcelas);
        return $retorno;

    }

    public function pagarMovimentacao($paciente_id, $desconto, $valor, $descricao, $movimentacao_id){
        $parcelas_aux = Parcela::where('movimentacao_id',$movimentacao_id)->get();
        $parcelas = $this->gerarParcelas($parcelas_aux);
        $mov = Movimentacao::find($movimentacao_id);
        $mov_tipo = MovimentacaoTipo::find($mov->tipo_id);

        if($mov_tipo->tipo == MovimentacaoTipo::TIPO_ID[MovimentacaoTipo::RECORRENTE]){
            $retorno = $this->pagarPlano($paciente_id, $desconto, $valor, $descricao, $parcelas);
        }else{
            $retorno = $this->pagarProduto($paciente_id, $desconto, $valor, $descricao, $parcelas);
        }
        return $retorno;
    }


    public function gerarPagamentoDebito($paciente_id, $desconto, $valor, $descricao, $movimentacao_id){
        $hoje = Carbon::now()->format('Y-m-d');
        $parcelas_aux = Parcela::where('movimentacao_id',$movimentacao_id)->where('data_vencimento', $hoje)->get();
        $mov = Movimentacao::find($movimentacao_id);
        $mov_tipo = MovimentacaoTipo::find($mov->tipo_id);
        $parcelas = $this->gerarParcelas($parcelas_aux);

        if($mov_tipo->tipo == MovimentacaoTipo::TIPO_ID[MovimentacaoTipo::RECORRENTE]){
            $retorno = $this->pagarPlano($paciente_id, $desconto, $valor, $descricao, $parcelas);
        }else{
            $retorno = $this->pagarProduto($paciente_id, $desconto, $valor, $descricao, $parcelas);
        }

        return $retorno;
    }

    public function estornarParcela($parcela_id){
        $parcela = Parcela::find($parcela_id);
        $retorno ="";
        if(!is_null($parcela)){
            if(!is_null($parcela->pagamento_id))
                $retorno = $this->estornarPagamento($parcela->pagamento_id);
        }
        return $retorno;
    }

    public function estornarPagamento($pagamento_id){
        $pag = Pagamento::find($pagamento_id);
        $mov = Movimentacao::find($pag->movimentacao_id);
        $par = Parcela::where('movimentacao_id', $mov->id)->get();
        $parcelas = collect($par);
        return $this->store(MovimentacaoTipo::TIPO_ID[MovimentacaoTipo::PAGAMENTO], 'E', $mov->pessoa_id, $mov->descontos, $mov->valor, "Estorno de pagamento", $parcelas, null, $pag->id);
    }

    public function estornarMovimentacao($movimentacao_id){
        $mov = Movimentacao::find($movimentacao_id);
        $par = Parcela::where('movimentacao_id', $mov->id)->get();
        $parcelas = collect($par);
        return $this->store(MovimentacaoTipo::TIPO_ID[MovimentacaoTipo::ESTORNO], 'E', $mov->pessoa_id, $mov->descontos, $mov->valor, $mov->descricao, $parcelas,$movimentacao_id);
    }


    public function store($tipo, $sentido, $paciente_id, $desconto, $valor, $descricao, $parcelas=null, $movimentacao_id=null, $pagamento_id =null, $guia_id=null ){

      $mov = new \App\Http\Controllers\Financeiro\MovimentacaoController();
        $financeiro = [];
        $financeiro['movimentacao_sentido'] = $sentido;//'D';
        $financeiro['movimentacao_tipo'] = $tipo;//(int) 6;
        $financeiro['pessoa_codigo'] = $paciente_id;//(($request->fk_pes_codigo == 0)||(is_null($request->fk_pes_codigo)) || ($request->fk_pes_codigo == "")) ? $a[0]['codigo'] : $request->fk_pes_codigo;
        $financeiro['user_id'] = $paciente_id;//\Auth::user()->id; // Auth (quem tiver logado)
        $financeiro['desconto'] = $desconto;//$request->desconto;
        $financeiro['descricao'] = $descricao;//$request->descricao;
        $financeiro['valor'] = $valor;//$request->valor;
        $financeiro['parcelas'] = $parcelas;

        if($tipo == MovimentacaoTipo::TIPO_ID[MovimentacaoTipo::ESTORNO]){
            $financeiro['movimentacao_id'] = $movimentacao_id;
        }
        if($tipo == MovimentacaoTipo::TIPO_ID[MovimentacaoTipo::PAGAMENTO]){
            $financeiro['pagamento_id'] = $pagamento_id;
        }
        if(!is_null($guia_id)){
            $financeiro['guia_id'] = $guia_id;
        }
        $dados = collect($financeiro);
        return $mov->store($dados);

    }


    public static function verificarPessoas(){
        //Verifica parcelas vencidas
        $pessoas = User::whereHas('plano',function ($q){
            $q->where('status',1);
        })->where('status',User::STATUS[User::ATIVO])->get();
    }

    public static function parcelasVencidas(){
        $today = Carbon::now()->format('Y-m-d');
        $parcelas = Parcela::where('status',Parcela::STATUS_ID[Parcela::ABERTA])->where('data_vencimento','<',$today)->get();
        foreach ($parcelas as $parcela){
            $par_aux = Parcela::find($parcela->id);
            if(!is_null($par_aux)){
                $par_aux->status = Parcela::STATUS_ID[Parcela::ATRASADA];
                $par_aux->save();
                $aviso = new Aviso([
                    'titulo' => "Vencimento de Parcelas",
                    'conteudo' => "Parcela vencida código: ".$parcela->id,
                    'data_validade' => Carbon::now()->addDays(3),
                    'pessoa_tipo' => User::TIPO[User::PROFISSIONAL],
                    'user_id' => 0,
                ]);
                $aviso->save();
            }
        }
    }


    public static function pagamentosAgendados(){

    }

}
