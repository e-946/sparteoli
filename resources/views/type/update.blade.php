@extends('adminlte::page')

@section('title', 'Sparteoli')

@section('content_header')
    <h1>Alterar tipo de operação</h1>
@stop

@section('content')
    <a class="btn btn-info mb-5" href="{{ url()->previous() == route('show-type', ['id' => $type->id]) ? route('show-type', ['id' => $type->id]) : route('index-type') }}">
        <i class="fas fa-arrow-left"></i>
        Voltar
    </a>
    <form method="post" class="" onsubmit="return confirm('Tem certeza que deseja atualizar {{addslashes( $type->name )}}?')">
        @method('PUT')
        @csrf
        <div class="form-group mb-2 mx-sm-3">
            <label for="name" class="mr-2">Nome:</label>
            <input id="name" type="text" name="name" class="form-control" value="{{ $type->name }}" autofocus>
            <label for="desc">Descricao do tipo de ocorrência:</label>
            <textarea id="desc" name="desc" form="form" class="form-control" placeholder="Digite a descrição da ocorrência...">{{$type->desc}}</textarea>
            <label for="nature">Natureza:</label>
            <select id="nature" class="form-control" name="nature_id">
                @foreach($natures as $nature)
                    <option value="{{$nature->id}}" {{ $nature->id == $type->nature->id ? 'selected' : ''}}>{{$nature->name}}</option>
                @endforeach
            </select>
        </div>
        <button type="submit" class="btn btn-primary mb-2">Salvar</button>
    </form>
@stop
