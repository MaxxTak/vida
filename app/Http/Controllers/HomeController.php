<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('home');
    }

    public function testeFinanceiro(){
        $fin = new FinanceiroController();
        $parcelas = [];
        $cont = 0;

        $aux = [];
        $aux['valor'] = 10;//$p['valor'];
        $aux['vencimento'] = Carbon::now()->format('Y-m-d');//$p['data'];
        $aux['fk_fpg_codigo'] = 1;//$parc['fk_fpg_codigo'];
        $aux['forma_pagamento'] = 1;//$parc['fk_fpg_codigo'];
        $aux['taxa'] = 0;//is_null($ptx) ? 0 : $ptx->ptx_valor_taxa ;
        $parcelas[$cont] = $aux;

        $ret = $fin->debitarProduto(1, 0, 10, "X", $parcelas);

        dd($ret);
    }
}
