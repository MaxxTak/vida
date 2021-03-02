@extends('layouts.basico')

@section('page-header')
	Prontuários <small>{{ trans('app.add_new_item') }}</small>
@stop

@section('content')
	@include('prontuarios.form')

	<div class="bgc-white bd bdrs-3 p-20 mB-20" style="text-align: center;">
        <button id="btnEnviar" class="btn btn-md btn-success" style="width: 100%;">Gravar</button>
    </div>
@stop

@push('scripts')
    <script type="text/javascript" src="{!! asset('/js/compartilhado/funcoes.js') !!}"></script>
    <script type="text/javascript" src="{!! asset('/js/compartilhado/sweetalert2.min.js') !!}"></script>
    <script type="text/javascript" src="{!! asset('/js/compartilhado/select2.min.js') !!}"></script>
	<script type="text/javascript" src="{!! asset('/js/prontuarios/prontuarios.js') !!}"></script>
@endpush