@extends('adminlte::page')

@section('title', 'Sparteoli')

@section('content_header')
    <h1>Alterar tipo de socorrista:</h1>
@stop

@section('content')
    <a class="btn btn-info mb-5" href="{{ route('index-rescuer') }}">
        <i class="fas fa-arrow-left"></i>
        Voltar
    </a>
    <form method="post" class="form-inline" onsubmit="return confirm('Tem certeza que deseja atualizar {{addslashes( $rescuer->name )}}?')">
        @method('PUT')
        @csrf
        <div class="form-group mb-2 mx-sm-3">
            <label for="name" class="mr-2">Nome:</label>
            <input id="name" type="text" name="name" class="form-control" value="{{ $rescuer->name }}" autofocus>
        </div>
        <button type="submit" class="btn btn-primary mb-2">Salvar</button>
    </form>
@stop
