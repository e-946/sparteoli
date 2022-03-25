@extends('adminlte::page')

@section('title', 'Sparteoli')

@section('content_header')
    <h1>Meio de chamado</h1>
@stop

@section('content')
    <div class="container">
        <div class="d-flex justify-content-end mb-5">
            @can('admin')
                <a href="{{route('create-meanused')}}" class="btn btn-success">
                    <i class="fas fa-plus"></i> Adicionar
                </a>
            @endauth
        </div>
        <div class="d-flex justify-content-center">
            <div class="list-group col-md-8">
                @include('message', ['message' => $message ?? ''])
                @include('errors', ['errors' => $errors])
                @foreach($means as $mean)
                    <div class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                        <p class="m-2">{{ $mean->name }}</p>
                        @can('admin')
                            <div class="d-flex justify-content-around m-2">
                                <a class="btn btn-primary mr-2" href="{{route('edit-meanused', $mean->id)}}">
                                    <p class="mb-0">
                                        <i class="fas fa-edit"></i>
                                        Atualizar
                                    </p>
                                </a>
                                <form method="post" action="{{ route('destroy-meanused', $mean->id) }}"
                                      onsubmit="return confirm('Tem certeza que deseja remover {{addslashes( $mean->name )}}?')">
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
