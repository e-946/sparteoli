@extends('adminlte::page')

@section('title', 'Sparteoli')

@section('content_header')
    <h1>Recursos empregados na ocorrência</h1>
@stop

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-5 flex-wrap">
        <a class="btn btn-info m-2" href="{{ route('show-occurrence', ['id' => $occurrence_id]) }}">
            <i class="fas fa-arrow-left"></i>
            Voltar
        </a>

        <div class="d-flex">
            <a href="{{route('create-resource', ['occurrence_id' => $occurrence_id])}}" class="btn btn-success">
                <i class="fas fa-plus"></i> Adicionar
            </a>
        </div>
    </div>
    <div class="container">
        <div class="d-flex justify-content-center">
            <div class="list-group col-md-8">
                @include('message', ['message' => $message ?? ''])
                @include('errors', ['errors' => $errors])
                @foreach($resources as $resource)
                    <div class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                        <a class="btn btn-outline-dark font-weight-bold m-2" href="{{ route('show-resource', ['occurrence_id' => $occurrence_id, 'id' => $resource->id]) }}">
                            {{ $resource->who }}
                        </a>
                        <div class="d-flex justify-content-around">
                            <a class="btn btn-primary mr-2" href="{{route('edit-resource', ['occurrence_id' => $occurrence_id, 'id' => $resource->id])}}">
                                <p class="mb-0">
                                    <i class="fas fa-edit"></i>
                                    Atualizar
                                </p>
                            </a>
                            <form method="post" action="{{ route('destroy-resource', ['occurrence_id' => $occurrence_id, 'id' => $resource->id]) }}"
                                  onsubmit="return confirm('Tem certeza que deseja remover {{addslashes( $resource->name )}}?')">
                                @method('DELETE')
                                @csrf
                                <button class="btn btn-danger">
                                    <i class="fas fa-trash"></i>
                                    Excluir
                                </button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@stop
