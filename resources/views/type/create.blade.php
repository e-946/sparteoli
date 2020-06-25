@extends('adminlte::page')

@section('title', 'Fireforce')

@section('content_header')
    <h1>Criar tipo de operação</h1>
@stop

@section('content')
    <a class="btn btn-info mb-5" href="{{ url()->previous() }}">
        <i class="fas fa-arrow-left"></i>
        Voltar
    </a>
    <form method="post" class="form-group">
        @csrf
        <div class="form-group mb-2 mx-sm-3">
            <label for="name">Nome:</label>
            <input id="name" type="text" name="name" class="form-control mb-2" placeholder="Tipo de ocorrência" autofocus>
            <label for="desc">Descricao do tipo de ocorrência:</label>
            <textarea id="desc" name="desc" form="form" class="form-control mb-2" placeholder="Digite a descrição da ocorrência..."></textarea>
            <label for="nature">Natureza:</label>
            <select id="nature" class="form-control" name="nature_id">
                <option disabled selected>Escolha uma natureza</option>
                @foreach($natures as $nature)
                    <option value="{{$nature->id}}">{{$nature->name}}</option>
                @endforeach
            </select>
        </div>
        <button type="submit" class="btn btn-success mt-2">Salvar</button>
    </form>
@stop
