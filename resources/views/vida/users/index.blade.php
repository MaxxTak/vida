@extends('vida.default')

@section('page-header')
    Usuários <small>{{ trans('app.manage') }}</small>
@endsection

@section('content')

    <div class="mB-20">
        <a href="{{ route(VIDA . '.users.create') }}" class="btn btn-info">
            {{ trans('app.add_button') }}
        </a>
    </div>


    <div class="bgc-white bd bdrs-3 p-20 mB-20">
        <table id="dataTable" class="table table-striped table-bordered" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th>Nome</th>
                    <th>Usuário</th>
                    <th>E-mail</th>
                    <th>Opções</th>
                </tr>
            </thead>
            
            <tfoot>
                <tr>
                    <th>Nome</th>
                    <th>Usuário</th>
                    <th>E-mail</th>
                    <th>Opções</th>
                </tr>
            </tfoot>
            
            <tbody>
                @foreach ($items as $item)
                    <tr>
                        <td><a href="{{ route(VIDA . '.users.edit', $item->id) }}">{{ $item->name }}</a></td>
                        <td><a href="{{ route(VIDA . '.users.edit', $item->id) }}">{{ $item->username }}</a></td>
                        <td>{{ $item->email }}</td>
                        <td>
                            <ul class="list-inline">
                                <li class="list-inline-item">
                                    <a href="{{ route(VIDA . '.users.edit', $item->id) }}" title="{{ trans('app.edit_title') }}" class="btn btn-primary btn-sm"><span class="ti-pencil"></span></a></li>
                                <li class="list-inline-item">
                                    {!! Form::open([
                                        'class'=>'delete',
                                        'url'  => route(VIDA . '.users.destroy', $item->id), 
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
    
@endsection