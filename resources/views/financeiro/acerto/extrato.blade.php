@extends('layouts.basico')

@section('page-header')
   Extrato <small>{{ trans('app.manage') }}</small>
@endsection
<link href="{{ asset('/css/compartilhado/select2.min.css') }}" rel="stylesheet">

@section('content')

    <div class="bgc-white bd bdrs-3 p-20 mB-20">
    <h4>
        @if(count($movs)>0)
        {{ $movs[0]->pessoa->user->name }}
            @endif
    </h4>
    <table>
        <thead>

        </thead>
        <tbody>
        @if(count($movs)>0)
            @foreach($movs as $mov)
                <th>
                    <td>{{ $mov->id }}</td>
                    <td>{{ $mov->movimentacao_guia_id }}</td>
                    <td>{{ $mov->status }}</td>
                    <td>{{ $mov->guia->created_at }}</td>
                    <td>{{ $mov->guia->valor_repasse }}</td>
                </th>
            @endforeach
        @else
            <h4> Sem Nenhuma Pendência</h4>
        @endif
        </tbody>
    </table>

    </div>


@endsection
@push('scripts')
    <script src="{{ mix('/js/app.js') }}"></script>
@endpush
