@extends('adminlte::page')

@section('title', 'Sparteoli')

@section('content_header')
    <h1>Recurso empregado por {{ $resource->who }}</h1>
@stop

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-5 flex-wrap">
        <a class="btn btn-info m-2" href="{{ route('index-resource', ['occurrence_id' => $occurrence_id]) }}">
            <i class="fas fa-arrow-left"></i>
            Voltar
        </a>
        <div class="d-flex justify-content-between align-items-center m-2">
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
    <div class="d-flex justify-content-center">
        <div class="list-group col-md-8">
            @include('message', ['message' => $message ?? ''])
            @include('errors', ['errors' => $errors])
            <div class="list-group-item">
                <div class="d-flex w-100 justify-content-between flex-wrap">
                    <h5 class="mb-1 font-weight-bold">Informações:</h5>
                    @if($resource->update_at)
                        <small>Última alteração: {{ date( 'd\/m\/Y - H:i', strtotime($resource->update_at->timezone('America/Bahia'))) }}</small>
                    @endif
                </div>
                <div class="mb-1 font-weight-normal">
                    <ul>
                        <li>
                            Quem empregou: {{ $resource->who }}
                        </li>
                        <li>
                            O que foi empregado: {{ $resource->what}}
                        </li>
                        <li>
                            Onde foi empregado: {{ $resource->where }}
                        </li>
                        <li>
                            Como foi empregado: {{ $resource->how }}
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
@stop
