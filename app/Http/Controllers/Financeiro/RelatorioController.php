<?php

namespace App\Http\Controllers\Financeiro;

use App\Models\Financeiro\Movimentacao;
use App\Models\Financeiro\Pagamento;
use App\Models\Financeiro\Parcela;
use App\Models\Financeiro\ParcelaPagamento;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class RelatorioController extends Controller
{

    public function retornarMovimentacao(Request $request){
        $status = $request->get('status');
        $dataI = $request->get('data_inicio');
        $dataF = $request->get('data_fim');
        $codP = $request->get('cod_pessoa');

        $retorno = Movimentacao::with('parcelas','guia','plano')
            ->select('movimentacoes.*','users.name','users.cnpjcpf','users.nim')
            ->join('pessoas','pessoa_id','pessoas.id')
            ->join('users','codigo_externo','users.id')
            ->where('sentido', 'D')
            ->when($status, function($query, $status){
                return $query->where('movimentacoes.status', '=', $status);
            })
            ->when($dataI, function($query, $dataI){
                return $query->where('movimentacoes.created_at', '>=', $dataI);
            })
            ->when($dataF, function($query, $dataF){
                return $query->where('movimentacoes.created_at', '<=', $dataF);
            })
            ->when($codP, function($query, $codP){
                return $query->where('users.id', '=', $codP);
            })
        ->get();
        $pessoas = User::all();
        $pessoas = $pessoas->pluck('name', 'id');
        $pessoas->prepend('Selecione uma pessoa', '');
        return view('financeiro.relatorios.movimentacao',['retorno'=>$retorno, 'pessoas' => $pessoas]);
    }

    public function contasPagarReceber(Request $request)
    {
        $status = $request->get('status');
        $dataI = $request->get('data_inicio');
        $dataF = $request->get('data_fim');
        $codP = $request->get('cod_pessoa');

        $formas_pagamento = $request->get('formas_pagamento');

        $parcelas = \DB::table('parcelas')
            ->select('parcelas.*', 'movimentacoes.descricao as mov_descricao' ,'movimentacoes.sentido as sentido', 'formas_pagamento.descricao as forma_pagamento','users.name')
            ->join('formas_pagamento', 'parcelas.fk_forma_pagamento','=','formas_pagamento.id')
            ->Join('movimentacoes', 'movimentacoes.id', '=', 'parcelas.movimentacao_id')
            ->join('pessoas','pessoa_id','pessoas.id')
            ->join('users','codigo_externo','users.id')
            ->where('parcelas.status','<>',3)
            ->when($status, function($query, $status){
                return $query->where('parcelas.status', '=', $status);
            })
            ->when($dataI, function($query, $dataI){
                return $query->where('parcelas.data_vencimento', '>=', $dataI);
            })
            ->when($dataF, function($query, $dataF){
                return $query->where('parcelas.data_vencimento', '<=', $dataF);
            })
            ->when($codP, function($query, $codP){
                return $query->where('pessoa.pes_codigo', '=', $codP);
            })

            ->get();

        $num_parcs = count($parcelas);

        $totalBrutoRecebido =0;
        $totalLiquidoRecebido =0;
        $totalBrutoAReceber =0;
        $totalLiquidoAReceber=0;
        $totalBrutoAReceberVencido =0;
        $totalLiquidoAReceberVencido =0;

        $totalBrutoPago=0;
        $totalLiquidoPago =0;

        $n_mov = 0;
        $count =0;
        $n_parc = 0;
        foreach ($parcelas as $parcela){
            if(($parcela->status != 3)&&($parcela->sentido == 'D')){
                if($n_mov != $parcela->movimentacao_id){
                    $count =0;

                    $n_mov = $parcela->movimentacao_id;
                    $n_parc = Parcela::where('movimentacao_id',$parcela->movimentacao_id)->count();
                    $parcela->total_parcelas = $n_parc;
                    $parcela->numero_parcela = $count +=1;
                    $parcela->valor_liquido = $parcela->valor - ($parcela->valor * ($parcela->taxa /100));
                }else{
                    $parcela->total_parcelas = $n_parc;
                    $parcela->numero_parcela = $count +=1;
                    $parcela->valor_liquido = $parcela->valor - ($parcela->valor * ($parcela->taxa /100));
                }

                if(!is_null($parcela->pagamento_id)){
                    $totalBrutoRecebido += $parcela->valor;
                    $totalLiquidoRecebido += $parcela->valor - ($parcela->valor * ($parcela->taxa / 100));
                    $pg = Pagamento::find($parcela->pagamento_id);
                    $parcela->data_pagamento = $pg->data;
                }else{
                    $parcela->data_pagamento = null;
                    if($parcela->data_vencimento < Carbon::now()->format('Y-m-d')){
                        $totalBrutoAReceberVencido += $parcela->valor;
                        $totalLiquidoAReceberVencido += $parcela->valor - ($parcela->valor * ($parcela->taxa / 100));
                    }else{
                        $totalBrutoAReceber += $parcela->valor;
                        $totalLiquidoAReceber += $parcela->valor - ($parcela->valor * ($parcela->taxa / 100));
                    }

                }
            }else if(($parcela->status != 3)&&($parcela->sentido == 'S')){
                if($n_mov != $parcela->movimentacao_id){
                    $count =0;

                    $n_mov = $parcela->movimentacao_id;
                    $n_parc = Parcela::where('movimentacao_id',$parcela->movimentacao_id)->count();
                    $parcela->total_parcelas = $n_parc;
                    $parcela->numero_parcela = $count +=1;
                    $parcela->valor_liquido = $parcela->valor - ($parcela->valor * ($parcela->taxa /100));
                }else{
                    $parcela->total_parcelas = $n_parc;
                    $parcela->numero_parcela = $count +=1;
                    $parcela->valor_liquido = $parcela->valor - ($parcela->valor * ($parcela->taxa /100));
                }

                if(!is_null($parcela->pagamento_id)){
                    $totalBrutoPago += $parcela->valor;
                    $totalLiquidoPago += $parcela->valor - ($parcela->valor * ($parcela->taxa / 100));
                    $pg = Pagamento::find($parcela->pagamento_id);
                    $parcela->data_pagamento = $pg->data;
                }

            }

        }

        $retorno = new \stdClass();
        $retorno->parcelas = $parcelas;
        $retorno->quantidadeParcelas = $num_parcs;
        $retorno->totalBrutoRecebido = $totalBrutoRecebido;
        $retorno->totalLiquidoRecebido = $totalLiquidoRecebido;
        $retorno->totalBrutoPago = $totalBrutoPago;
        $retorno->totalLiquidoPago = $totalLiquidoPago;

        $retorno = collect($retorno);
        $pessoas = User::all();
        $pessoas = $pessoas->pluck('name', 'id');
        $pessoas->prepend('Selecione uma pessoa', '');
        return view('financeiro.relatorios.contas',['retorno'=>$retorno,'pessoas'=>$pessoas]);
    }

    public function parcelasPagamentos(Request $request)
    {
        $status = $request->get('status');
        $dataI = $request->get('data_inicio');
        $dataF = $request->get('data_fim');
        $codP = $request->get('cod_pessoa');

        $formas_pagamento = $request->get('formas_pagamento');

        $parcelas = \DB::table('parcelas')
            ->select('parcelas.*', 'formas_pagamento.descricao as forma_pagamento','movimentacoes.sentido' ,'users.name as nome')
            ->join('formas_pagamento', 'parcelas.fk_forma_pagamento','=','formas_pagamento.id')
            ->Join('movimentacoes', 'movimentacoes.id', '=', 'parcelas.movimentacao_id')
            ->join('pessoas','pessoa_id','pessoas.id')
            ->join('users','codigo_externo','users.id')

            ->when($status, function($query, $status){
                return $query->where('parcelas.status', '=', $status);
            })
            ->when($dataI, function($query, $dataI){
                return $query->where('parcelas.data_vencimento', '>=', $dataI);
            })
            ->when($dataF, function($query, $dataF){
                return $query->where('parcelas.data_vencimento', '<=', $dataF);
            })
            ->when($codP, function($query, $codP){
                return $query->where('users.id', '=', $codP);
            })

            ->get();

        $num_parcs = count($parcelas);

        $totalBrutoRecebido =0;
        $totalLiquidoRecebido =0;
        $totalBrutoAReceber =0;
        $totalLiquidoAReceber=0;
        $totalBrutoAReceberVencido =0;
        $totalLiquidoAReceberVencido =0;

        $n_mov = 0;
        $count =0;
        $n_parc = 0;
        foreach ($parcelas as $parcela){
            $parcela->valor_liquido = $parcela->valor - ($parcela->valor * ($parcela->taxa /100));

            if(($parcela->status != 3)&&($parcela->sentido == 'E')){
                if($n_mov != $parcela->movimentacao_id){
                    $count =0;

                    $n_mov = $parcela->movimentacao_id;
                    $n_parc = Parcela::where('movimentacao_id',$parcela->movimentacao_id)->count();
                    $parcela->total_parcelas = $n_parc;
                    $parcela->numero_parcela = $count +=1;
                    $parcela->valor_liquido = $parcela->valor - ($parcela->valor * ($parcela->taxa /100));
                }else{
                    $parcela->total_parcelas = $n_parc;
                    $parcela->numero_parcela = $count +=1;
                    $parcela->valor_liquido = $parcela->valor - ($parcela->valor * ($parcela->taxa /100));
                }

                if(!is_null($parcela->pagamento_id)){
                    $totalBrutoRecebido += $parcela->valor;
                    $totalLiquidoRecebido += $parcela->valor - ($parcela->valor * ($parcela->taxa / 100));
                    $pg = Pagamento::find($parcela->pagamento_id);
                    $parcela->data_pagamento = $pg->data;
                }else{
                    $parcela->data_pagamento = null;
                    if($parcela->data_vencimento < Carbon::now()->format('Y-m-d')){
                        $totalBrutoAReceberVencido += $parcela->valor;
                        $totalLiquidoAReceberVencido += $parcela->valor - ($parcela->valor * ($parcela->taxa / 100));
                    }else{
                        $totalBrutoAReceber += $parcela->valor;
                        $totalLiquidoAReceber += $parcela->valor - ($parcela->valor * ($parcela->taxa / 100));
                    }

                }
            }

        }

        $retorno = new \stdClass();
        $retorno->parcelas = $parcelas;
        $retorno->quantidadeParcelas = $num_parcs;
        $retorno->totalBrutoAReceber = $totalBrutoAReceber;
        $retorno->totalLiquidoAReceber = $totalLiquidoAReceber;
        $retorno->totalBrutoAReceberVencido = $totalBrutoAReceberVencido;
        $retorno->totalLiquidoAReceberVencido = $totalLiquidoAReceberVencido;

        $retorno = collect($retorno);
        $pessoas = User::all();
        $pessoas = $pessoas->pluck('name', 'id');
        $pessoas->prepend('Selecione uma pessoa', '');
        return view('financeiro.relatorios.parcelas',['retorno'=>$retorno,'pessoas'=>$pessoas]);
    }

    public function pagamentosEstornados(Request $request)
    {
        $dataI = $request->get('data_inicio');
        $dataF = $request->get('data_fim');
        $codP = $request->get('user_id');
        $codPExt = $request->get('cod_pessoa_externo');

        $estorno = \DB::table('estornos')
            ->select('estornos.*', 'pes_nome as nome', 'pes_email as email', 'pessoas.codigo_externo as codigo_externo')
            ->leftJoin('pessoas', 'pessoas.id', '=', 'pessoa_id')
            ->join('users','pessoas.codigo_externo','users.id')

            ->when($codP, function($query, $codP){
                return $query->where('users', '=', $codP);
            })
            ->when($codPExt, function($query, $codPExt){
                return $query->where('codigo_externo', '=', $codPExt);
            })
            ->when($dataI, function($query, $dataI){
                return $query->where('data_estorno', '>=', $dataI);
            })
            ->when($dataF, function($query, $dataF){
                return $query->where('data_estorno', '<=', $dataF);
            })
            ->get();

        foreach($estorno as $est)
        {
            if($est->pagamentos_id != null){
                $pag = Pagamento::find($est->pagamentos_id);
                $est->pagamento = $pag;
            }else{
                $est->pagamento = null;
            }
        }

        $ttbruto = 0;
        $ttliquido = 0;

        foreach ($estorno as $est) {
            $ttbruto += $est->valor;
            $ttliquido += $est->valor;
        }

        $estornos = collect($estorno);

        $totalQuantidade = $estornos->count();

        $retorno = collect();
        $retorno->put('totalBruto', $ttbruto);
        $retorno->put('totalLiquido', $ttliquido);
        $retorno->put('totalQuantidade', $totalQuantidade);
        $retorno->put('estornos', $estornos);

        return $retorno;
    }

    public function movimentacoesEstornadas(Request $request)
    {
        $dataI = $request->get('data_inicio');
        $dataF = $request->get('data_fim');
        $codP = $request->get('user_id');
        $codPExt = $request->get('cod_pessoa_externo');

        $estorno = \DB::table('movimentacoes_estornadas')
            ->select('movimentacoes_estornadas.*', 'pes_nome as nome', 'pes_email as email', 'pessoas.codigo_externo as codigo_externo')
            ->leftJoin('pessoas', 'pessoas.id', '=', 'pessoa_id')
            ->leftJoin('users','pessoas.codigo_externo','users.id')

            ->when($codP, function($query, $codP){
                return $query->where('users.id', '=', $codP);
            })
            ->when($codPExt, function($query, $codPExt){
                return $query->where('codigo_externo', '=', $codPExt);
            })
            ->when($dataI, function($query, $dataI){
                return $query->where('data_estorno', '>=', $dataI);
            })
            ->when($dataF, function($query, $dataF){
                return $query->where('data_estorno', '<=', $dataF);
            })
            ->get();

        $ttbruto = 0;
        $ttliquido = 0;

        foreach($estorno as $est)
        {
            if($est->movimentacao_id_estornada != null){
                $mov = Movimentacao::find($est->movimentacao_id_estornada);
                $est->movimentacao = $mov;
            }else{
                $est->movimentacao = null;
            }

            $ttbruto += $est->movimentacao['valor'];
            $ttliquido += $est->movimentacao['valor_total'];
        }

        $estornos = collect($estorno);

        $totalQuantidade = $estornos->count();

        $retorno = collect();
        $retorno->put('totalBruto', $ttbruto);
        $retorno->put('totalLiquido', $ttliquido);
        $retorno->put('totalQuantidade', $totalQuantidade);
        $retorno->put('estornos', $estornos);

        return $retorno;
    }

    public function contasCorrente(Request $request)
    {
        $codP = $request->get('user_id');
        $codPExt = $request->get('cod_pessoa_externo');
        $dataI = $request->get('data_inicio');
        $dataF = $request->get('data_fim');


        $cc = \DB::table('contas_corrente')
            ->select('contas_corrente.id','contas_corrente.descricao','contas_corrente.saldo','contas_corrente.valor_servicos','contas_corrente.created_at', 'pes_nome as nome', 'pes_num_matricula as matricula', 'pes_codigo')
            ->join('pessoas', 'pessoas.id', '=', 'contas_corrente.pessoa_id')
            ->join('users','pessoas.codigo_externo','users.id')

            ->when($codP, function($query, $codP){
                return $query->where('users.id', '=', $codP);
            })
            ->when($codPExt, function($query, $codPExt){
                return $query->where('codigo_externo', '=', $codPExt);
            })
            ->when($dataI, function($query, $dataI){
                return $query->where('movimentacoes.created_at', '>=', $dataI);
            })
            ->when($dataF, function($query, $dataF){
                return $query->where('movimentacoes.created_at', '<=', $dataF);
            })
            ->get();

        $ttbruto = 0;
        $ttliquido = 0;

        foreach ($cc as $cred) {
            $ttbruto += $cred->saldo;
            $ttliquido += ($cred->saldo - $cred->valor_servicos);
        }

        $contas = collect($cc);

        $totalQuantidade = $contas->count();

        $retorno = collect();
        $retorno->put('totalBruto', $ttbruto);
        $retorno->put('totalLiquido', $ttliquido);
        $retorno->put('totalQuantidade', $totalQuantidade);
        $retorno->put('contas', $contas);

        return $retorno;
    }


}
