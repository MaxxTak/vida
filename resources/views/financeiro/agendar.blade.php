@extends('layouts.basico')

@section('page-header')
   Agendar Pagamento <small>{{ trans('app.manage') }}</small>
@endsection
<link href="{{ asset('/css/compartilhado/select2.min.css') }}" rel="stylesheet">

@section('content')

    <div class="bgc-white bd bdrs-3 p-20 mB-20">



    </div>


@endsection
@push('scripts')
    <script src="{{ mix('/js/app.js') }}"></script>
@endpush
