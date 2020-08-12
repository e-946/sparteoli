@extends('adminlte::page')

@section('title', 'Fireforce')

@section('content_header')
    <h1>Adicionar proteção contra incêndio</h1>
@stop

@section('content')
    <a class="btn btn-info mb-5" href="{{ url()->previous() == route('index-fireprotection') ? route('index-fireprotection') : url()->previous() }}">
        <i class="fas fa-arrow-left"></i>
        Voltar
    </a>
    <form method="post" class="">
        @csrf
        <div class="form-group form-row mb-2">
            <div class="col">
                <label for="name" class="mr-2">Nome:</label>
                <input id="name" type="text" name="name" class="form-control" placeholder="Nome da proteção" autofocus>
            </div>
            <div class="col">
                <label for="desc" class="mr-2">Descrição:</label>
                <textarea id="desc" type="text" name="desc" class="form-control" placeholder="Descrição"></textarea>
            </div>
        </div>
        <button type="submit" class="btn btn-success mb-2">Salvar</button>
    </form>
@stop
