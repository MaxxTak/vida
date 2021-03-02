@extends('layouts.basico')

@section('page-header')
   Baixa <small>{{ trans('app.manage') }}</small>
   <style>
       .table-overflow {
           max-height:100px;
           overflow-y:auto;
       }

   </style>
@endsection
<link href="{{ asset('/css/compartilhado/select2.min.css') }}" rel="stylesheet">

@section('content')
    <div class="row mB-40">
        <div class="col-md-8">
            <div class="tab">
                <button class="tablinks" onclick="openCity(event, 'Pessoal')">Geral</button>
                <button class="tablinks" onclick="openCity(event, 'Endereco')">Parcelas</button>
                <button class="tablinks" onclick="openCity(event, 'Usuario')">Movimentações</button>
            </div>
            <!-- =======================================TAB Geral================================================================= -->
            <div id="Pessoal" class="tabcontent">
                <div class="masonry-item">
                    <!-- #Monthly Stats ==================== -->
                    <div class="bd bgc-white">
                        <div class="layers">
                            <div class="layer w-100 pX-20 pT-20">
                                <h6 class="lh-1">Status Mensais (R$)</h6>
                            </div>

                            <div class="layer w-100 p-20">
                                <canvas id="line-chart" height="220"></canvas>
                            </div>


                        </div>
                    </div>
                </div>
            </div>
            <!-- =======================================END TAB GERAL================================================================= -->
            <!-- =======================================TAB PARCELAS================================================================= -->
            <div id="Endereco" class="tabcontent">
                <div class="masonry-item">
                    <!-- #Monthly Stats ==================== -->
                    <div class="bd bgc-white">
                        <div class="layers">
                            <div class="layer w-100 pX-20 pT-20">
                                <h6 class="lh-1">Parcelas (R$)</h6>
                            </div>

                            <div class="layer w-100 p-20">
                                <canvas id="line-parcela-chart" height="220"></canvas>
                            </div>


                        </div>
                    </div>
                </div>

            </div>
            <!-- =======================================END TAB PARCELAS ================================================================= -->

            <!-- =======================================TAB MOVIMENTAÇÕES ================================================================= -->

            <div id="Usuario" class="tabcontent">
                <div class="masonry-item">
                    <!-- #Monthly Stats ==================== -->
                    <div class="bd bgc-white">
                        <div class="layers">
                            <div class="layer w-100 pX-20 pT-20">
                                <h6 class="lh-1">Movimentações</h6>
                            </div>

                            <div class="layer w-100 p-20">
                                <canvas id="line-mov-chart" height="220"></canvas>
                            </div>



                        </div>
                    </div>
                </div>




            </div>
            <!-- =======================================END TAB MOVIMENTAÇÕES================================================================= -->

        </div>
        <div class="col-md-3">
            <h4>
                {{ Form::label('_pag', 'Pagamentos(mês atual):',['id'=>'_pag']) }}
            </h4>
            <div class="table-overflow">
                <table id="" class="table table-bordered">
                    <thead>
                    <tr>
                        <th>Id</th>
                        <th>Valor</th>
                        <th>Data</th>

                    </tr>
                    </thead>
                    <tbody>
                        @foreach($pagamentos as $pagamento)
                            <tr>
                                <td>{{ $pagamento->id }}</td>
                                <td>{{ $pagamento->valor }}</td>
                                <td>{{ $pagamento->data }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <br/>

            <h4>
                {{ Form::label('_par', 'Parcelas Atrasadas:',['id'=>'_par']) }}
            </h4>
            <div class="table-overflow">
                <table id="" class="table table-bordered">
                    <thead>
                    <tr>
                        <th>Id</th>
                        <th>Valor</th>
                        <th>Vencimento</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($parcelas as $parcela)
                        <tr>
                            <td>{{ $parcela->id }}</td>
                            <td>{{ $parcela->valor }}</td>
                            <td>{{ $parcela->data_vencimento }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>

            <br/>

            <h4>
                {{ Form::label('_par', 'Parcelas à receber(mês atual):',['id'=>'_par']) }}
            </h4>
            <div class="table-overflow">
                <table id="" class="table table-bordered">
                    <thead>
                    <tr>
                        <th>Id</th>
                        <th>Valor</th>
                        <th>Vencimento</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($parcelas_abertas as $parcela)
                        <tr>
                            <td>{{ $parcela->id }}</td>
                            <td>{{ $parcela->valor }}</td>
                            <td>{{ $parcela->data_vencimento }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>

        </div>
    </div>
    <div class="row mB-40">
        <h3>
            {{ Form::label('_par', 'Entrada/Saída(mês atual):',['id'=>'_par']) }}
        </h3>
        <div class="col-md-11">
            <table id="empresas" class="table table-bordered">
                <thead>
                <tr>
                    <th>Movimentação</th>
                    <th>Descrição</th>
                    <th>Guia</th>
                    <th>Plano Contas</th>
                    <th>Pessoa</th>
                    <th>Data Criação</th>
                    <th>Forma Pagamento</th>
                    <th>Entradas</th>
                    <th>Saídas</th>
                    <th>À receber</th>

                </tr>
                </thead>
                <tbody>
                @foreach($baixas as $baixa)
                    <tr>
                        <td>{{ $baixa->id }}</td>
                       <!-- <td>{{ isset($baixa->fpg)? 'Entrada Pagamento': (($baixa->sentido=='D')?'Plano Paciente':'Pagamento Profissional') }}</td> -->
                        <td>{{ $baixa->descricao }}</td>
                        <td>{{ !is_null($baixa->movimentacao_guia_id)? $baixa->movimentacao_guia_id : '--' }}</td>
                        <td>{{ !is_null($baixa->plano_contas_id)? $baixa->plano_contas_id : '--' }}</td>
                        <td>{{ $baixa->pessoa->user->name }}</td>
                        <td>{{ $baixa->created_at }}</td>
                        <td>{{ isset($baixa->fpg) ? $baixa->fpg : '--' }}</td>
                        @if(isset($baixa->fpg))
                            <td style="background-color:#0ac578; color: black"> +{{ $baixa->valor_total }}</td>
                        @else
                            <td>   </td>
                        @endif
                        @if((!isset($baixa->fpg))&&($baixa->sentido=='C'))
                            <td style="background-color:#9d0a0e; color: black"> -{{ $baixa->valor_total }}</td>
                        @else
                            <td>   </td>
                        @endif
                        @if((!isset($baixa->fpg))&&($baixa->sentido=='D'))
                            <td style="background-color:#0b75c9; color: black">  {{ $baixa->valor_total }}</td>
                        @else
                            <td>   </td>
                        @endif

                    </tr>
                @endforeach

                </tbody>
            </table>
            <br/>
            <br/>
            <table class="table table-striped">
                <tbody>
                <tr>
                    <td colspan="7"> Total À Receber</td>
                    <td colspan="3"> 10</td>
                </tr>
                <tr>
                    <td colspan="7"> Total Saída</td>
                    <td colspan="3"> 10</td>
                </tr>
                <tr>
                    <td colspan="7"> Total Entrada</td>
                    <td colspan="3"> 10</td>
                </tr>
                <tr>
                    <td colspan="7"> TOTAL</td>
                    <td colspan="3"> 10</td>
                </tr>

                </tbody>
            </table>

        </div>
    </div>
@endsection
@push('scripts')
    <script src="{{ mix('/js/app.js') }}"></script>
    <script type="text/javascript" src="{!! asset('/js/pessoa/tab.js') !!}"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="{!! asset('/js/pessoa/pessoa.js') !!}"></script>
@endpush
