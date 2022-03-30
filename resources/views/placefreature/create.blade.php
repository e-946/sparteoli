@extends('adminlte::page')

@section('title', 'Sparteoli')

@section('content_header')
    <h1>Adicionar característica de local</h1>
@stop

@section('content')
    <a class="btn btn-info mb-5" href="{{ url()->previous() == route('index-placefreature') ? route('index-placefreature') : url()->previous() }}">
        <i class="fas fa-arrow-left"></i>
        Voltar
    </a>
    <form method="post" class="">
        @csrf
        <div class="form-group mb-2">
            <label for="name" class="">Nome:</label>
            <input id="name" type="text" name="name" class="form-control" placeholder="Característica do local" autofocus>
        </div>
        <button type="submit" class="btn btn-success">Salvar</button>
    </form>
@stop
