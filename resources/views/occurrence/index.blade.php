@extends('adminlte::page')

@section('title', 'Fireforce')

@section('content_header')
    <h1>As ocorrências</h1>
@stop


@section('content')
    <div class="container">
        <div class="d-flex justify-content-end mb-5">
            <a href="{{route('create-occurrence')}}" class="btn btn-success">
                <i class="fas fa-plus"></i> Adicionar
            </a>
        </div>
        <div class="d-flex justify-content-center">
            <div class="list-group col-md-8">
                @foreach($occurrences as $occurrence)
                    <div class="list-group-item d-flex justify-content-between align-content-center flex-wrap">
                        <a class="link-muted" href="{{ route('show-occurrence', $occurrence->id) }}">
                            <p class="mb-0">{{ $occurrence->id }}</p>
                        </a>
                        <div class="d-flex justify-content-around">
                            <a class="btn btn-primary mr-2" href="{{route('edit-occurrence', $occurrence->id)}}">
                                <p class="mb-0">
                                    <i class="fas fa-edit"></i>
                                    Atualizar
                                </p>
                            </a>
                            <form method="post" action="{{ route('destroy-occurrence', $occurrence->id) }}"
                                  onsubmit="return confirm('Tem certeza que deseja remover {{addslashes( $occurrence->id )}}?')">
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
