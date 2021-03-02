@extends('layouts.basico')

@section('page-header')
    Permissões <small>{{ trans('app.manage') }}</small>
@endsection

@section('content')
    <div class="mB-20">

    </div>
    <div class="bgc-white bd bdrs-3 p-20 mB-20">
        {!! Form::open(array('url' => '/vida/paciente/permissao')) !!}
        {{ csrf_field() }}
        {!! Form::mySelect('paciente_id', 'Paciente', $pacientes, null, ['id' => 'paciente_id','required']) !!}
        {!! Form::mySelect('grupo_id', 'Permissão', $permissoes, null, ['id' => 'grupo_id','required']) !!}
        <div class="peer">
            <button type="submit" class="btn btn-primary">Confirmar</button>
        </div>
        {{ Form::close() }}

    </div>
@endsection

@push('scripts')
    <script src="{{ mix('/js/app.js') }}"></script>
@endpush
