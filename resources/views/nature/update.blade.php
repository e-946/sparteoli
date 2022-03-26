@extends('adminlte::page')

@section('title', 'Sparteoli')

@section('content_header')
    <h1>Alterar natureza de operação</h1>
@stop

@section('content')
    <a class="btn btn-info mb-5" href="{{ url()->previous() == route('show-nature', ['id' => $nature->id]) ? route('show-nature', ['id' => $nature->id]) : route('index-nature') }}">
        <i class="fas fa-arrow-left"></i>
        Voltar
    </a>
    <form method="post" class="" onsubmit="return confirm('Tem certeza que deseja atualizar {{addslashes( $nature->name )}}?')">
        @method('PUT')
        @csrf
        <div class="form-group mb-2">
            <label for="name" class="">Nome:</label>
            <input id="name" type="text" name="name" class="form-control" value="{{ $nature->name }}" autofocus>
        </div>
        <button type="submit" class="btn btn-primary">Salvar</button>
    </form>
@stop
