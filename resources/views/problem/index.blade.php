@extends('adminlte::page')

@section('title', 'Sparteoli')

@section('content_header')
    <h1>Tipos de problemas</h1>
@stop

@section('content')
    <div class="container">
        <div class="d-flex justify-content-end align-items-center mb-5">
            @can('admin')
                <a href="{{route('create-problem')}}" class="btn btn-success">
                    <i class="fas fa-plus"></i> Adicionar
                </a>
            @endauth
        </div>
        <div class="d-flex justify-content-center">
            <div class="list-group col-md-8">
                @include('message', ['message' => $message ?? ''])
                @include('errors', ['errors' => $errors])
                @foreach($problems as $problem)
                    <div class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                        <a class="btn btn-outline-dark font-weight-bold m-2" href="{{ route('show-problem', $problem->id) }}">
                            {{ $problem->name }}
                        </a>
                        @can('admin')
                            <div class="d-flex justify-content-around">
                                <a class="btn btn-primary mr-2" href="{{route('edit-problem', $problem->id)}}">
                                    <p class="mb-0">
                                        <i class="fas fa-edit"></i>
                                        Atualizar
                                    </p>
                                </a>
                                <form method="post" action="{{ route('destroy-problem', $problem->id) }}"
                                      onsubmit="return confirm('Tem certeza que deseja remover {{addslashes( $problem->name )}}?')">
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
