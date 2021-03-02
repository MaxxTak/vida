@extends('layouts.basico')

@section('page-header')
    Movimentações <small>{{ trans('app.manage') }}</small>
@endsection

@section('content')
    <div class="mB-20">

    </div>
    <div class="bgc-white bd bdrs-3 p-20 mB-20">
        @if(count($movimentacoes))
            <div id="accordion-container">
                <div>
                    <table id="empresas" class="table table-striped" style="width:100%">
                        <thead>
                            <tr>
                                <th>Código</th>
                                <th>Pessoa</th>
                                <th>Valor</th>
                                <th>Status</th>
                                <th>Data Criação</th>
                                <th>Opções</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>Código</th>
                                <th>Pessoa</th>
                                <th>Valor</th>
                                <th>Status</th>
                                <th>Data Criação</th>
                                <th>Opções</th>
                            </tr>
                        </tfoot>
                        <tbody>
                        @foreach($movimentacoes as $movimentacao)
                            <tr>
                                <td>{{$movimentacao->id}}</td>
				@if(isset($movimentacao->pessoa->user->name))
					<td>{{$movimentacao->pessoa->user->name}}</td>
				@else
					<td></td>
				@endif
                                <td>{{$movimentacao->valor}}</td>
                                <td>{{ \App\Models\Financeiro\Movimentacao::STATUS[$movimentacao->status] }}</td>
                                <td>{{$movimentacao->created_at}}</td>
                                <td>
                                    <ul class="list-inline">
                                        <li class="list-inline-item">
                                            <a title="Parcelas" onclick="abrirParcela({{$movimentacao->id}})" class="btn btn-primary btn-sm"><span class="ti-package"></span></a>
                                        </li>
                                        <li class="list-inline-item">
                                            <a title="DELETAR" onclick="movDeletar({{$movimentacao->id}})" class="btn btn-danger btn-sm"><span class="ti-trash"></span></a>
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
            <h3>Nenhuma movimentação cadastrada</h3>
        @endif
    </div>


    <!-- The Modal Titular -->
    <div class="modal" id="myModal">
        <div class="modal-dialog modal-lg "><!-- modal-dialog-centered -->
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Parcelas</h4>
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
                            <th>Vencimento</th>
                            <th>Opções</th>
                        </tr>
                        </thead>
                    </table>
                    <h3>Entrada:</h3>
                    <table id="myModalTableMovimentacao" class="table table-striped">

                    </table>
                    <h3>Mensalidades:</h3>
                    <table id="myModalTableMovimentacao2" class="table table-striped">

                    </table>
                    {{ Form::hidden('movimentacao_id_modal', 1, ['id'=>'movimentacao_id_modal']) }}

                </div>
                <!-- Modal footer -->
                <div class="modal-footer">
                <!-- <button  class="btn btn-primary" onclick="myPostParcela()">Create row</button> -->
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
