@extends('layouts.basico')

@section('page-header')
    Empresas <small>{{ trans('app.manage') }}</small>
@endsection

@section('content')
    <div class="mB-20">
        <a href="/vida/registrar?tipo=1" class="btn btn-info">
            {{ trans('app.add_button') }}
        </a>
    </div>
    <div class="bgc-white bd bdrs-3 p-20 mB-20">
        @if(count($empresas))
            <div id="accordion-container">
                <div>
                    <table id="empresas" class="table table-striped" style="width:100%">
                        <thead>
                            <tr>
                                <th>Nome</th>
                                <th>Nome</th>
                                <th>Documento</th>
                                <th>Opções</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>Nome</th>
                                <th>Nome</th>
                                <th>Documento</th>
                                <th>Opções</th>
                            </tr>
                        </tfoot>
                        <tbody>
                        @foreach($empresas as $empresa)
                            <tr>
                                <td>{{$empresa->name}}</td>
                                <td>{{$empresa->empresa->nome_fantasia}}</td>
                                <td>{{$empresa->cnpjcpf}}</td>
                                <td>
                                    <ul class="list-inline">
                                        <li class="list-inline-item">
                                            <a href="/vida/pessoa/edit/{{$empresa->id}}?tipo=1" title="{{ trans('app.edit_title') }}" class="btn btn-primary btn-sm"><span class="ti-pencil"></span></a>
                                        </li>
                                        <li class="list-inline-item">
                                            <a href='profissional_procedimentos?profissional={{$empresa->id}}' title="Procedimentos" class="btn btn-success btn-sm"><span class="ti-write"></span></a>
                                        </li>
                                        <li class="list-inline-item">
                                            {!! Form::open([
                                                'class'=>'delete',
                                                'url'  => '#',
                                                'method' => 'DELETE',
                                                ])
                                            !!}

                                                <button class="btn btn-danger btn-sm" title="{{ trans('app.delete_title') }}"><i class="ti-trash"></i></button>

                                            {!! Form::close() !!}
                                        </li>
                                    </ul>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @else
            <h3>Nenhuma empresa cadastrada</h3>
        @endif
    </div>
@endsection

@push('scripts')
    <script src="{{ mix('/js/app.js') }}"></script>
    <script type="text/javascript" src="{!! asset('/js/pessoa/tab.js') !!}"></script>
    <script type="text/javascript" src="{!! asset('/js/pessoa/pessoa.js') !!}"></script>
@endpush
