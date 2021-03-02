@extends('layouts.basico')

@section('page-header')
    Teste Impressão <small>{{ trans('app.manage') }}</small>
@endsection

@section('content')

    <iframe id="impressaoGuia" src="/print/guia.html" style="width:0;height:0;border: 0;border: none;"></iframe>

    <button id="teste">Teste</button>

@endsection
@push('scripts')
    <script src="{{ mix('/js/app.js') }}"></script>
    <script type="text/javascript" src="{!! asset('/js/guias/print.js') !!}"></script>
@endpush
