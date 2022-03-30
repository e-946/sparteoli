@extends('adminlte::page')

@section('title', 'Sparteoli')

@section('content_header')
    <h1>Natureza de operação {{ $nature->name }}</h1>
@stop

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-5 flex-wrap">
        <a class="btn btn-info m-2" href="{{ route('index-nature') }}">
            <i class="fas fa-arrow-left"></i>
            Voltar
        </a>
        @can('admin')
            <div class="d-flex justify-content-center align-items-center m-2">
                <a class="btn btn-primary mr-2" href="{{route('edit-nature', $nature->id)}}">
                    <p class="mb-0">
                        <i class="fas fa-edit"></i>
                        Atualizar
                    </p>
                </a>
                <form method="post" action="{{ route('destroy-nature', $nature->id) }}"
                      onsubmit="return confirm('Tem certeza que deseja remover {{addslashes( $nature->name )}}?')">
                    @method('DELETE')
                    @csrf
                    <button class="btn btn-danger">
                        <i class="fas fa-trash"></i>
                        Excluir
                    </button>
                </form>
            </div>
        @endauth
    </div>
    <div class="d-flex justify-content-center">
        <div class="list-group col-md-8">
            @include('message', ['message' => $message ?? ''])
            @include('errors', ['errors' => $errors])
            <div class="list-group-item">
                <div class="d-flex w-100 justify-content-between flex-wrap">
                    <h5 class="mb-1 font-weight-bold">Informações:</h5>
                    <small>Tipos de ocorrência com essa natureza: {{ $nature->types->count() }}</small>
                    <small>Ocorrência com essa natureza: {{ $nature->occurrences->count() }}</small>
                    <small>Última alteração: {{ date( 'd\/m\/Y - H:i', strtotime($nature->updated_at)) }}</small>
                </div>
                <p class="mb-1 font-weight-normal">{{ $nature->desc }}</p>
                <div class="list-group">
                @foreach($nature->types as $type)
                    <a class="btn btn-outline-dark list-group-item" href="{{route('show-type', $type->id)}}">{{ $type->name }}</a>
                @endforeach
                </div>
                <small>Criado em: {{ date( 'd\/m\/Y - H:i', strtotime($nature->created_at)) }}</small>
            </div>
        </div>
    </div>
@stop
