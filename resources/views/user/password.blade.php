@extends('adminlte::page')

@section('title', 'Sparteoli')

@section('content_header')
    <h1>Alterar senha {{ $user->name }}</h1>
@stop

@section('content')
    <a class="btn btn-info mb-5" href="{{ url()->previous() == route('index-user') ? route('index-user') : url()->previous() }}">
        <i class="fas fa-arrow-left"></i>
        Voltar
    </a>
    <form method="post" action="{{route('password-store', $user->id)}}" class="form-group" onsubmit="return confirm('Tem certeza que deseja atualizar a senha de {{addslashes( $user->name )}}?')">
        @method('PUT')
        @csrf
        <div class="mb-2 mx-sm-3 has-feedback {{ $errors->has('password') ? 'has-error' : '' }}">
            <label for="password">Digite a nova senha:</label>
            <input id="password" type="password" name="password" class="form-control"
                   placeholder="{{ trans('adminlte::adminlte.password') }}" autofocus>
            @if ($errors->has('password'))
                <small class="help-block text-danger">
                    <strong>{{ $errors->first('password') }}</strong>
                </small>
                <br>
            @endif
            <label for="password_confirmation">Confirme a senha:</label>
            <input id="password_confirmation" type="password" name="password_confirmation" class="form-control"
                   placeholder="{{ trans('adminlte::adminlte.retype_password') }}">
            @if ($errors->has('password_confirmation'))
                <small class="help-block text-danger">
                    <strong>{{ $errors->first('password_confirmation') }}</strong>
                </small>
                <br>
            @endif
        </div>
        <button type="submit" class="btn btn-primary">Salvar</button>
    </form>
@stop
