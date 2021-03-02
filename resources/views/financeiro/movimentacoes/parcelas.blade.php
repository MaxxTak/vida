@extends('layouts.basico')

@section('page-header')
    Parcelas <small>{{ trans('app.manage') }}</small>
@endsection

@section('content')
    <div class="mB-20">

    </div>
    <div class="bgc-white bd bdrs-3 p-20 mB-20">
        @if(count($parcelas))
            <div id="accordion-container">
                <div>
                    <table id="empresas" class="table table-striped" style="width:100%">
                        <thead>
                            <tr>
                                <th>Código</th>
                                <th>Pessoa</th>
                                <th>Valor</th>
                                <th>Forma Pagamento</th>
                                <th>Vencimento</th>
                                <th>Status</th>
                                <th>Opções</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>Código</th>
                                <th>Pessoa</th>
                                <th>Valor</th>
                                <th>Forma Pagamento</th>
                                <th>Vencimento</th>
                                <th>Status</th>
                                <th>Opções</th>
                            </tr>
                        </tfoot>
                        <tbody>
                        @foreach($parcelas as $parcela)
                            <tr>
                                <td>{{$parcela->id}}</td>
				@if(isset($parcela->movimentacao->pessoa->user->name))
					<td>{{$parcela->movimentacao->pessoa->user->name}}</td>
				@else
					<td></td>
				@endif
                                <td>{{$parcela->valor}}</td>
                                <td>{{$parcela->forma->descricao}}</td>
                                <td>{{$parcela->data_vencimento}}</td>
                                <td>{{ \App\Models\Financeiro\Parcela::STATUS[$parcela->status] }}</td>
                                <td>
                                    <ul class="list-inline">
                                        @if($parcela->status == \App\Models\Financeiro\Parcela::STATUS_ID[\App\Models\Financeiro\Parcela::ABERTA])
                                        <li class="list-inline-item">
                                            <a onclick="pagarParcela({{$parcela->id}})" title="Pagar Parcela" class="btn btn-success btn-sm"><span class="ti-money"></span></a>
                                        </li>
                                        @elseif($parcela->status == \App\Models\Financeiro\Parcela::STATUS_ID[\App\Models\Financeiro\Parcela::PAGA])
                                            <li class="list-inline-item">
                                                <button onclick="movEstornarParcela({{$parcela->id}})" class="btn btn-warning btn-sm" title="Estornar"><i class="ti-money"></i></button>
                                            </li>
                                        @endif
                                            <li class="list-inline-item">
                                                <a onclick="movDeletarParcela({{$parcela->id}})" title="Deletar Parcela" class="btn btn-danger btn-sm"><span class="ti-trash"></span></a>
                                            </li>
                                    </ul>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @else
            <h3>Nenhuma parcela cadastrada</h3>
        @endif
    </div>

    <!-- The Modal Titular -->
    <div class="modal" id="myModal">
        <div class="modal-dialog modal-lg "><!-- modal-dialog-centered -->
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Pagar uma parcela</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <!-- Modal body -->
                <div class="modal-body">
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th>Código</th>
                            <th>Pessoa</th>
                            <th>Valor</th>
                        </tr>
                        </thead>
                    </table>
                    <table id="myModalTableParcela" class="table table-striped">

                    </table>
                    {{ Form::hidden('parcela_id_modal', 1, ['id'=>'parcela_id_modal']) }}
                    {!! Form::mySelect('forma_pagamento_id_parcela', 'Forma Pagamento', $fpg, null, ['id'=> 'forma_pagamento_id_parcela','name' => 'forma_pagamento_id','required']) !!}
                </div>
                <!-- Modal footer -->
                <div class="modal-footer">
                    <button  class="btn btn-success" onclick="myPostParcela()">Pagar Parcela</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                </div>

            </div>
        </div>
    </div>

@endsection

@push('scripts')
    <script src="{{ mix('/js/app.js') }}"></script>
    <script type="text/javascript" src="{!! asset('/js/compartilhado/sweetalert2.min.js') !!}"></script>
    <script type="text/javascript" src="{!! asset('/js/financeiro/fin.js') !!}"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="{!! asset('/js/pessoa/pessoa.js') !!}"></script>
@endpush
