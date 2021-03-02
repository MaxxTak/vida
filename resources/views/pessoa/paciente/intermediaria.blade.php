@extends('layouts.basico')

@section('content')
    <input type="hidden" id="id" name="id" value="{{ $id }}">
@endsection

@push('scripts')
    <script src="{{ mix('/js/app.js') }}"></script>
    <script type="text/javascript" src="{!! asset('/js/pessoa/tab.js') !!}"></script>
    <script type="text/javascript" src="{!! asset('/js/pessoa/intermediaria.js') !!}"></script>
    <script type="text/javascript" src="{!! asset('/js/compartilhado/sweetalert2.min.js') !!}"></script>
@endpush
