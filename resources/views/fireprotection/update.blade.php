@extends('adminlte::page')

@section('title', 'Sparteoli')

@section('content_header')
    <h1>Alterar sistema de proteção: {{$protection->name}}</h1>
@stop

@section('content')
    <a class="btn btn-info mb-5" href="{{ url()->previous() == route('show-fireprotection', ['id' => $protection->id]) ? route('show-fireprotection', ['id' => $protection->id]) : route('index-fireprotection') }}">
        <i class="fas fa-arrow-left"></i>
        Voltar
    </a>
    <form method="post" class="" onsubmit="return confirm('Tem certeza que deseja atualizar {{addslashes( $protection->name )}}?')">
        @method('PUT')
        @csrf
        <div class="form-group mb-2 form-row">
            <div class="col">
                <label for="name" class="mr-2">Nome:</label>
                <input id="name" type="text" name="name" class="form-control" value="{{ $protection->name }}" autofocus>
            </div>
            <div class="col">
                <label for="desc" class="mr-2">Descrição:</label>
                <textarea id="desc" type="text" name="desc" class="form-control">{{ $protection->desc }}</textarea>
            </div>
        </div>
        <button type="submit" class="btn btn-primary mb-2">Salvar</button>
    </form>
@stop
