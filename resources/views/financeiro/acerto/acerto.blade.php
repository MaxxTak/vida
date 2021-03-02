@extends('layouts.basico')

@section('page-header')
   Acerto <small>{{ trans('app.manage') }}</small>
@endsection
<link href="{{ asset('/css/compartilhado/select2.min.css') }}" rel="stylesheet">

@section('content')

    <div class="bgc-white bd bdrs-3 p-20 mB-20">
        @if(count($contas)>0)
        <table id="empresas" class="table table-bordered">
            <thead>
            <tr>
                <th>Código</th>
                <th>Nome</th>
                <th>Saldo</th>
                <th>Opções</th>
            </tr>
            </thead>
            <tbody>

            @foreach($contas as $conta)
                <tr>
                    <td>{{ $conta->id }}</td>
                    <td>{{ $conta->pessoa->user->name }}</td>
                    <td>{{ $conta->saldo }}</td>
                    <td>
                        <ul class="list-inline">
                            <li class="list-inline-item">
                                <a id="acerto-button"  name ="acerto-button" title="Fazer Acerto" class="btn btn-info btn-sm" href="/vida/extrato?pr_id={{ $conta->pessoa->user->id }}"><span class="ti-info"></span></a>
                            </li>
                        </ul>
                    </td>
                </tr>
            @endforeach

            </tbody>
        </table>
        @else
            <h4>Sem acertos para realizar</h4>
        @endif
    </div>


@endsection
@push('scripts')
    <script src="{{ mix('/js/app.js') }}"></script>
@endpush
