@extends('adminlte::page')

@section('title', 'Sparteoli')

@section('content_header')
    <h1>Tipo de operação {{ $type->name }}</h1>
@stop

@section('content')
    <div class="d-flex justify-content-between mb-5 flex-wrap">
        <a class="btn btn-info" href="{{ route('index-type') }}">
            <i class="fas fa-arrow-left"></i>
            Voltar
        </a>
        @can('admin')
            <div class="d-flex">
                <a class="btn btn-primary mr-2" href="{{route('edit-type', $type->id)}}">
                    <p class="mb-0">
                        <i class="fas fa-edit"></i>
                        Atualizar
                    </p>
                </a>
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
    <div class="d-flex justify-content-center">
        <div class="list-group col-md-8">
            @include('errors', ['errors' => $errors])
            <div class="list-group-item">
                <div class="d-flex w-100 justify-content-between flex-wrap">
                    <h5 class="mb-1 font-weight-bold">Informações:</h5>
                    <small>Última alteração: {{ date( 'd\/m\/Y - H:i', strtotime($type->update_at)) }}</small>
                </div>
                <p class="mb-1 font-weight-normal">{{$type->desc}}</p>
                <div class="list-group-item">
                    Natureza:
                    <a href="{{route('show-nature', $type->nature->id)}}" class="link-muted">
                        {{ $type->nature->name }}
                    </a>
                </div>
            </div>
        </div>
    </div>
@stop
