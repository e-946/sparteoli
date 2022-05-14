@extends('adminlte::page')

@section('title', 'Sparteoli')

@section('content_header')
    <h1>Atualizar {{$user->name}}</h1>
@stop

@section('content')
    <a class="btn btn-info mb-5" href="{{ url()->previous() == route('index-user') ? route('index-user') : url()->previous() }}">
        <i class="fas fa-arrow-left"></i>
        Voltar
    </a>
    <form method="post" class="" onsubmit="return confirm('Tem certeza que deseja atualizar {{addslashes( $user->name )}}?')">
        @method('PUT')
        @csrf
        <div class="">
            <label for="name" class="mr-2 form-control-label">Nome:</label>
            <div class="input-group has-feedback mb-3 {{ $errors->has('name') ? 'has-error' : '' }}">
                <input id="name" type="text" name="name" class="form-control" value="{{ $user->name }}" autofocus>
                <div class="input-group-append">
                    <div class="input-group-text">
                        <span class="fas fa-user {{ config('adminlte.classes_auth_icon', '') }}"></span>
                    </div>
                </div>
                @if ($errors->has('name'))
                    <small class="help-block text-danger">
                        <strong>{{ $errors->first('name') }}</strong>
                    </small>
                    <br>
                @endif
            </div>
            <label for="register" class="form-control-label mr-2">Matrícula:</label>
            <div class="input-group has-feedback mb-3 {{ $errors->has('register') ? 'has-error' : '' }}">
                <br>
                <input id="register" {{Auth::user()->admin ? '' : 'disabled'}} type="text" name="register" class="form-control" value="{{ $user->register }}">
                <div class="input-group-append">
                    <div class="input-group-text">
                        <span class="fas fa-key {{ config('adminlte.classes_auth_icon', '') }}"></span>
                    </div>
                </div>
                @if ($errors->has('register'))
                    <small class="help-block text-danger">
                        <strong>{{ $errors->first('register') }}</strong>
                    </small>
                @endif
            </div>
            @can('admin')
                <div class="input-group mb-3 d-flex align-items-center">
                    <label for="admin" class="form-check-label mr-3">Usuário é administrador?</label>
                    <input id="admin" type="checkbox" name="admin" value="1" class="checkbox" {{$user->admin ? 'checked' : ''}}>
                </div>
            @endcan
        </div>
        <button type="submit" class="btn btn-primary mb-2">Salvar</button>
    </form>
@stop
