@extends('layouts.basico')

@section('page-header')
    Procedimentos <small>{{ trans('app.manage') }}</small>
@endsection

@section('content')

    <div class="mB-20">
        <a href="{{ route(VIDA . '.procedimentos.create') }}" class="btn btn-info">
            {{ trans('app.add_button') }}
        </a>
    </div>


    <div class="bgc-white bd bdrs-3 p-20 mB-20">
        <table id="tabela-procedimentos" class="table table-striped" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Descrição</th>
                    <th>Especialidade</th>
                    <th>Preparo</th>
                    <th>Opções</th>
                </tr>
            </thead>
            
            <tfoot>
                <tr>
                    <th>#</th>
                    <th>Descrição</th>
                    <th>Especialidade</th>
                    <th>Preparo</th>
                    <th>Opções</th>
                </tr>
            </tfoot>
            
            <tbody>
                @foreach ($items as $item)
                    <tr>
                        <td><a href="{{ route(VIDA . '.procedimentos.edit', $item->id) }}">{{ $item->id }}</a></td>
                        <td><a href="{{ route(VIDA . '.procedimentos.edit', $item->id) }}">{{ $item->descricao }}</a></td>
                        <td>{{ $item->especialidade }}</td>
                        <td>{{ $item->preparo }}</a></td>
                        <td>
                            <ul class="list-inline">
                                <li class="list-inline-item">
                                    <a href="{{ route(VIDA . '.procedimentos.edit', $item->id) }}" title="{{ trans('app.edit_title') }}" class="btn btn-primary btn-sm"><span class="ti-pencil"></span></a>
                                </li>
                                <!--<li class="list-inline-item">
                                    {!! Form::open([
                                        'class'=>'delete',
                                        'url'  => route(VIDA . '.procedimentos.destroy', $item->id), 
                                        'method' => 'DELETE',
                                        ]) 
                                    !!}

                                        <button class="btn btn-danger btn-sm" title="{{ trans('app.delete_title') }}"><i class="ti-trash"></i></button>
                                        
                                    {!! Form::close() !!}
                                </li>-->
                            </ul>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        
        </table>
    </div>
@endsection
@push('scripts')
    <script src="{{ mix('/js/app.js') }}"></script>
    <script type="text/javascript" src="{!! asset('/js/procedimentos/procedimentos.js') !!}"></script>
@endpush