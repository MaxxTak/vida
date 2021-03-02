@extends('layouts.basico')

@section('page-header')
    Permissões <small>{{ trans('app.manage') }}</small>
@endsection

@section('content')
    <div class="mB-20">

    </div>

@endsection

@push('scripts')
    <script src="{{ mix('/js/app.js') }}"></script>
    <script type="text/javascript" src="{!! asset('/js/pessoa/empresa.js') !!}"></script>
@endpush
