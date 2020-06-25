@extends('adminlte::page')

@section('title', 'Fireforce')

@section('content_header')
    <h1>Natureza de operação {{ $nature->name }}</h1>
@stop

@section('content')
    <div class="d-flex justify-content-between mb-5 flex-wrap">
        <a class="btn btn-info" href="{{ url()->previous() }}">
            <i class="fas fa-arrow-left"></i>
            Voltar
        </a>
        @can('admin')
            <div class="d-flex">
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
            <div class="list-group-item">
                <div class="d-flex w-100 justify-content-between flex-wrap">
                    <h5 class="mb-1 font-weight-bold">Informações:</h5>
                    <small>Tipos de ocorrência com essa natureza: {{ $nature->types->count() }}</small>
                    <small>Última alteração: {{ date( 'd\/m\/Y - H:i', mktime($nature->update_at)) }}</small>
                </div>
                <p class="mb-1 font-weight-normal">
                    @foreach($nature->types as $type)
                        <div  class="list-group-item">
                            <a class="list-group-item-heading link-muted" href="{{route('show-type', $type->id)}}">{{ $type->name }}</a>
                        </div>
                    @endforeach
            </div>
        </div>
    </div>
@stop
