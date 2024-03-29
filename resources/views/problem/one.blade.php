@extends('adminlte::page')

@section('title', 'Sparteoli')

@section('content_header')
    <h1>Tipo de problema {{ $problem->name }}</h1>
@stop

@section('content')
    <div class="d-flex justify-content-between align-content-center mb-5 flex-wrap">
        <a class="btn btn-info m-2" href="{{ route('index-problem') }}">
            <i class="fas fa-arrow-left"></i>
            Voltar
        </a>
        @can('admin')
            <div class="d-flex justify-content-between align-content-center m-2">
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
    <div class="d-flex justify-content-center">
        <div class="list-group col-md-8">
            @include('message', ['message' => $message ?? ''])
            @include('errors', ['errors' => $errors])
            <div class="list-group-item">
                <div class="d-flex w-100 justify-content-between flex-wrap">
                    <h5 class="mb-1 font-weight-bold">Informações:</h5>
                    @if($problem->updated_at)
                        <small>Última alteração: {{ date( 'd\/m\/Y - H:i', strtotime($problem->updated_at->timezone('America/Bahia'))) }}</small>
                    @endif
                </div>
                <p class="mb-1 font-weight-normal">{{ $problem->desc }}</p>
                @if($problem->created_at)
                    <small>Data : {{ date( 'd\/m\/Y - H:i', strtotime($problem->created_at->timezone('America/Bahia'))) }}</small>
                @endif
            </div>
        </div>
    </div>
@stop
