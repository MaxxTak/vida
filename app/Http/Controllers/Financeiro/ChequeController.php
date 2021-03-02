<?php

namespace App\Http\Controllers\Financeiro;

use App\Http\Requests\ChequeRequest;
use App\Models\Financeiro\Cheque;
use Illuminate\Http\Request;

class ChequeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        $documento = $request->get('documento');
        $banco = $request->get('banco');
        $cheques = Cheque::where('status',1)
            ->when($documento, function ($q) use ($documento) {
                return $q->where('documento', 'LIKE', "%$documento%");
            })
            ->when($banco, function ($q) use ($banco) {
                return $q->where('banco', 'LIKE', "%$banco%");
            })->get()
        ;
        return $cheques;
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
    public function store(ChequeRequest $request)
    {
        //
        $cheque = new Cheque([
            'nome'=>$request->get('nome'),
            'documento'=>$request->get('documento'),
            'comp'=>$request->get('comp') ,
            'banco'=>$request->get('banco'),
            'cooperativa'=>$request->get('cooperativa'),
            'conta'=>$request->get('conta'),
            'numero'=>$request->get('numero'),
            'valor'=>$request->get('valor'),
            'data'=>$request->get('data')
        ]);
        $cheque->save();
        return $cheque;
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
        return Cheque::find($id);
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
        $cheque = Cheque::find($id);
        if($request->has('nome')){
            $cheque->nome = $request->get('nome');
        }
        if($request->has('documento')){
            $cheque->documento = $request->get('documento');
        }
        if($request->has('comp')){
            $cheque->comp = $request->get('comp');
        }
        if($request->has('banco')){
            $cheque->banco = $request->get('banco');
        }
        if($request->has('cooperativa')){
            $cheque->cooperativa = $request->get('cooperativa');
        }
        if($request->has('conta')){
            $cheque->conta = $request->get('conta');
        }
        if($request->has('numero')){
            $cheque->numero = $request->get('numero');
        }
        if($request->has('valor')){
            $cheque->valor = $request->get('valor');
        }
        if($request->has('data')){
            $cheque->data = $request->get('data');
        }
        $cheque->save();
        return $cheque;
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
        $cheque = Cheque::find($id);
        $cheque->delete();

        return '';
    }
}
