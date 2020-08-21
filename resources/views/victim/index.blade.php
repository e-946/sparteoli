@extends('adminlte::page')

@section('title', 'Sparteoli')

@section('content_header')
    <h1>Tipos de vítimas</h1>
@stop

@section('content')
    <div class="d-flex justify-content-between mb-5 flex-wrap">
        <a class="btn btn-info" href="{{ route('show-occurrence', ['id' => $occurrence_id]) }}">
            <i class="fas fa-arrow-left"></i>
            Voltar
        </a>

        <div class="d-flex">
            <a href="{{route('create-victim', ['occurrence_id' => $occurrence_id])}}" class="btn btn-success">
                <i class="fas fa-plus"></i> Adicionar
            </a>
        </div>
    </div>
    <div class="container">
        <div class="d-flex justify-content-center">
            <div class="list-group col-md-8">
                @include('errors', ['errors' => $errors])
                @foreach($victims as $victim)
                    <div class="list-group-item d-flex justify-content-between align-content-center flex-wrap">
                        <a class="link-muted" href="{{ route('show-victim', ['occurrence_id' => $occurrence_id, 'id' => $victim->id]) }}">
                            <p class="mb-0">{{ $victim->name }}</p>
                        </a>
                        <div class="d-flex justify-content-around">
                            <a class="btn btn-primary mr-2" href="{{route('edit-victim', ['occurrence_id' => $occurrence_id, 'id' => $victim->id])}}">
                                <p class="mb-0">
                                    <i class="fas fa-edit"></i>
                                    Atualizar
                                </p>
                            </a>
                            <form method="post" action="{{ route('destroy-victim', ['occurrence_id' => $occurrence_id, 'id' => $victim->id]) }}"
                                  onsubmit="return confirm('Tem certeza que deseja remover {{addslashes( $victim->name )}}?')">
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
