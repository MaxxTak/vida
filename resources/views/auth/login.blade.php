@extends('layouts.app')

@section('content')

    <h4 class="fw-300 c-grey-900 mB-40">Entrar</h4>
    <form class="form-horizontal" method="POST" action="{{ route('login') }}">
        {{ csrf_field() }}

        <div class="form-group{{ $errors->has('username') ? ' has-error' : '' }}">
            <label for="username" class="text-normal text-dark">Usuário</label>
            <input id="username" type="username" class="form-control" name="username" value="{{ old('username') }}" required autofocus>

            @if ($errors->has('username'))
                <span class="form-text text-danger">
                    <small>{{ $errors->first('username') }}</small>
                </span>
            @endif
        </div>

        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
            <label for="password" class="text-normal text-dark">Senha</label>
            <input id="password" type="password" class="form-control" name="password" required>

            @if ($errors->has('password'))
                <span class="form-text text-danger">
                    <small>{{ $errors->first('password') }}</small>
                </span>
            @endif
        </div>

        <div class="form-group">
            <div class="peers ai-c jc-sb fxw-nw">
                <div class="peer">
                    <div class="checkbox checkbox-circle checkbox-info peers ai-c">
                        <input type="checkbox" id="remember" name="remember" class="peer" {{ old('remember') ? 'checked' : '' }}>
                        <label for="remember" class=" peers peer-greed js-sb ai-c">
                            <span class="peer peer-greed">Lembrar senha</span>
                        </label>
                    </div>
                </div>
                <div class="peer">
                    <button class="btn btn-primary">Entrar</button>
                </div>
            </div>
        </div>
        <div class="peers ai-c jc-sb fxw-nw">
            <div class="peer">
                <a class="btn btn-link" href="{{ route('password.request') }}">
                    Esqueceu sua senha?
                </a>
            </div>
            <div class="peer">
                <a href="/register" class="btn btn-link">Criar nova conta</a>
            </div>
        </div>
    </form>

@endsection
