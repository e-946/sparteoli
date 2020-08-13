@extends('adminlte::page')

@section('title', 'Fireforce')

@section('content_header')
    <h1>Alterar vítima:</h1>
@stop

@section('content')
    <a class="btn btn-info mb-5" href="{{ url()->previous() === route('show-resource', ['occurrence_id' => $occurrence_id, 'id' => $resource->id]) ? route('show-resource', ['occurrence_id' => $occurrence_id, 'id' => $resource->id]) : route('index-resource', ['occurrence_id' => $occurrence_id]) }}">
        <i class="fas fa-arrow-left"></i>
        Voltar
    </a>
    <form method="post" class="" onsubmit="return confirm('Tem certeza que deseja atualizar {{addslashes( $resource->who )}}?')">
        @method('PUT')
        @csrf
        <div class="form-row mb-3">
            <div class="col">
                <label for="who" class="">De quem é o recurso:</label>
                <input id="who" type="text" name="who" class="form-control" placeholder="Digite o responsável pelo recurso" value="{{ $resource->who }}" autofocus required>
            </div>
            <div class="col">
                <label for="what" class="">O que foi empregado:</label>
                <input id="what" type="text" name="what" class="form-control" placeholder="Digite qual recurso foi empregado" value="{{ $resource->what }}" required>
            </div>
        </div>

        <div class="form-row mb-3">
            <div class="col">
                <label for="where" class="">Onde foi empregado:</label>
                <input id="where" type="text" name="where" class="form-control" placeholder="Digite onde o recurso foi empregado" value="{{ $resource->where }}" required>
            </div>
            <div class="col">
                <label for="how" class="">Como foi empregado:</label>
                <input id="how" type="text" name="how" class="form-control" placeholder="Digite como o recurso foi empregado" value="{{ $resource->how }}" required>
            </div>
        </div>
        <button type="submit" class="btn btn-success mb-2">Salvar</button>
    </form>
@stop
