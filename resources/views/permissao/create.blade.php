@extends('layouts.basico')

@section('page-header')
    Permissões <small>{{ trans('app.manage') }}</small>
@endsection

@section('content')
    <div class="mB-20">

    </div>

       <div class="row bgc-white bd bdrs-3 p-20 mB-20">
           <div class="col-lg-offset-8">
               <form method="POST" action="/vida/permissao">
                   {{ csrf_field() }}

                   <div class="form-group{{ $errors->has('nome') ? ' has-error' : '' }}">
                       <label for="nome" class="text-normal text-dark">Nome</label>
                       <input id="nome" type="text" class="form-control" name="nome" value="{{ old('nome') }}" required>

                       @if ($errors->has('nome'))
                           <span class="form-text text-danger">
                                <small>{{ $errors->first('nome') }}</small>
                            </span>
                       @endif
                   </div>

                   <div class="form-group{{ $errors->has('descricao') ? ' has-error' : '' }}">
                       <label for="descricao" class="text-normal text-dark">Descrição</label>
                       <textarea id="descricao" type="text" class="form-control" name="descricao" value="{{ old('descricao') }}" required> </textarea>

                       @if ($errors->has('descricao'))
                           <span class="form-text text-danger">
                                    <small>{{ $errors->first('descricao') }}</small>
                                </span>
                       @endif
                   </div>
                   <label for="permissoes" class="text-normal text-dark">Permissões</label>
                   @foreach($permissoes as $permissao)
                       <div class="form-group{{ $errors->has($permissao->nome) ? ' has-error' : '' }}">
                           <input type="checkbox" id="{{ $permissao->nome }}" name="{{ $permissao->nome }}" value="{{ $permissao->valor }}"> {{ \App\Models\Permissao::PERMISSAO[$permissao->valor] }}<br>
                       </div>
                   @endforeach


                   <div class="form-group">
                       <div class="peers ai-c jc-sb fxw-nw">
                           <div class="peer">
                               <a href="/login">Retornar para home</a>
                           </div>
                           <div class="peer">
                               <button class="btn btn-primary">{{ trans('app.add_button') }}</button>
                           </div>
                       </div>
                   </div>
               </form>
           </div>

       </div>



@endsection

@push('scripts')
    <script src="{{ mix('/js/app.js') }}"></script>
    <script type="text/javascript" src="{!! asset('/js/pessoa/empresa.js') !!}"></script>
@endpush
