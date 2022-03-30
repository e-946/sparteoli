@extends('adminlte::page')

@section('title', 'Sparteoli')

@section('content_header')
    <h1>Adicionar meio de chamado</h1>
@stop

@section('content')
    <a class="btn btn-info mb-5" href="{{ url()->previous() == route('index-meanused') ? route('index-meanused') : url()->previous() }}">
        <i class="fas fa-arrow-left"></i>
        Voltar
    </a>
    <form method="post" class="">
        @csrf
        <div class="form-group mb-2">
            <label for="name" class="">Nome:</label>
            <input id="name" type="text" name="name" class="form-control" placeholder="Meio de chamado" autofocus>
        </div>
        <button type="submit" class="btn btn-success">Salvar</button>
    </form>
@stop
