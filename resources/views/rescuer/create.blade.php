@extends('adminlte::page')

@section('title', 'Sparteoli')

@section('content_header')
    <h1>Adicionar tipo de socorrista</h1>
@stop

@section('content')
    <a class="btn btn-info mb-5" href="{{ url()->previous() == route('index-rescuer') ? route('index-rescuer') : url()->previous() }}">
        <i class="fas fa-arrow-left"></i>
        Voltar
    </a>
    <form method="post" class="form-inline">
        @csrf
        <div class="form-group mb-2 mx-sm-3">
            <label for="name" class="mr-2">Nome:</label>
            <input id="name" type="text" name="name" class="form-control" placeholder="Tipo de socorrista" autofocus>
        </div>
        <button type="submit" class="btn btn-success mb-2">Salvar</button>
    </form>
@stop
