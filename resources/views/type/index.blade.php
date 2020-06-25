@extends('adminlte::page')

@section('title', 'Fireforce')

@section('content_header')
    <h1>Natureza de operação</h1>
@stop

@section('content')
    <div class="container">
        <div class="d-flex justify-content-end mb-5">
            @can('admin')
                <a href="{{route('create-type')}}" class="btn btn-success">
                    <i class="fas fa-plus"></i> Adicionar
                </a>
            @endauth
        </div>
        <div class="d-flex justify-content-center">
            <div class="list-group col-md-8">
                @foreach($types as $type)
                    <div class="list-group-item d-flex justify-content-between align-content-center flex-wrap">
                        <a class="link-muted" href="{{ route('show-type', $type->id) }}">
                            <p class="mb-0">{{ $type->name }}</p>
                            <small class="list-group-item-heading"><b>Natureza:</b></small>
                            <small class="list-group-item-text">{{ $type->nature->name }}</small>
                        </a>
                        @can('admin')
                            <div class="d-flex justify-content-around">
                                <div class="mr-2">
                                    <a class="btn btn-primary" href="{{route('edit-type', $type->id)}}">
                                        <i class="fas fa-edit"></i>
                                        Atualizar
                                    </a>
                                </div>
                                <form method="post" action="{{ route('destroy-type', $type->id) }}"
                                      onsubmit="return confirm('Tem certeza que deseja remover {{addslashes( $type->name )}}?')">
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
                @endforeach
            </div>
        </div>
    </div>
@stop
