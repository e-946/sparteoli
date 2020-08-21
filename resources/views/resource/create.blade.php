@extends('adminlte::page')

@section('title', 'Sparteoli')

@section('content_header')
    <h1>Adicionar Recurso</h1>
@stop

@section('content')
    <a class="btn btn-info mb-5" href="{{ url()->previous() === route('show-occurrence', ['id' => $occurrence_id]) ? route('show-occurrence', ['id' => $occurrence_id]) : route('index-resource', ['occurrence_id' => $occurrence_id]) }}">
        <i class="fas fa-arrow-left"></i>
        Voltar
    </a>
    <form method="post">
        @csrf
        <div class="mb-2 mx-sm-3">
            <div class="form-row mb-3">
                <div class="col">
                    <label for="who" class="">De quem é o recurso:</label>
                    <input id="who" type="text" name="who" class="form-control" placeholder="Digite o responsável pelo recurso" autofocus required>
                </div>
                <div class="col">
                    <label for="what" class="">O que foi empregado:</label>
                    <input id="what" type="text" name="what" class="form-control" placeholder="Digite qual recurso foi empregado" required>
                </div>
            </div>

            <div class="form-row mb-3">
                <div class="col">
                    <label for="where" class="">Onde foi empregado:</label>
                    <input id="where" type="text" name="where" class="form-control" placeholder="Digite onde o recurso foi empregado" required>
                </div>
                <div class="col">
                    <label for="how" class="">Como foi empregado:</label>
                    <input id="how" type="text" name="how" class="form-control" placeholder="Digite como o recurso foi empregado" required>
                </div>
            </div>
        </div>
        <button type="submit" class="btn btn-success mb-2">Salvar</button>
    </form>
@stop
