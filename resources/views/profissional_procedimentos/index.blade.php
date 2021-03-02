@extends('layouts.basico')

@section('page-header')
    Procedimentos / Profissional <small>{{ trans('app.manage') }}</small>
@endsection
<link href="{{ asset('/css/compartilhado/select2.min.css') }}" rel="stylesheet">

@section('content')

    <div class="bgc-white bd bdrs-3 p-20 mB-20">
        <h4>Filtros</h4>
        {!! Form::mySelect('user_id', 'Profissional', $profissionais, $profissional, ['name' => 'user_id']) !!}
        {!! Form::mySelect('especialidade_id', 'Especialidades', $especialidades, $profissionalEspecialidades, ["multiple"]) !!}
    </div>

    <div class="bgc-white bd bdrs-3 p-20 mB-20">
        <h4>Procedimentos / Profissional</h4>
        <table id="tabela-procedimentos-profissional" class="table table-striped" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Descrição</th>
                    <th>Valor</th>
                    <th>Valor Particular</th>
                    <th>Valor Repasse</th>
                    <th>% Repasse</th>
                    <th>Tempo Atendimento</th>
                    <th>Opções</th>
                </tr>
            </thead>
            
            <tfoot>
                <tr>
                    <th>#</th>
                    <th>Descrição</th>
                    <th>Valor</th>
                    <th>Valor Particular</th>
                    <th>Valor Repasse</th>
                    <th>% Repasse</th>
                    <th>Tempo Atendimento</th>
                    <th>Opções</th>
                </tr>
            </tfoot>
        </table>
    </div>

    <div class="bgc-white bd bdrs-3 p-20 mB-20">
        <h4>Procedimentos / Especialidades</h4>
        <table id="tabela-procedimentos-especialidades" class="table table-striped" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Descrição</th>
                    <th>Especialidade</th>
                    <th>Opções</th>
                </tr>
            </thead>
            
            <tfoot>
                <tr>
                    <th>#</th>
                    <th>Descrição</th>
                    <th>Especialidade</th>
                    <th>Opções</th>
                </tr>
            </tfoot>
        </table>
    </div>
@endsection
@push('scripts')
    <script src="{{ mix('/js/app.js') }}"></script>
    <script type="text/javascript" src="{!! asset('/js/compartilhado/funcoes.js') !!}"></script>
    <script type="text/javascript" src="{!! asset('/js/compartilhado/sweetalert2.min.js') !!}"></script>
    <script type="text/javascript" src="{!! asset('/js/profissional_procedimentos/index.js') !!}"></script>
    <script type="text/javascript" src="{!! asset('/js/compartilhado/jquery.mask.min.js') !!}"></script>
    <script type="text/javascript" src="{!! asset('/js/compartilhado/select2.min.js') !!}"></script>
@endpush