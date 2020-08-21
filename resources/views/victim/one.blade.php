@extends('adminlte::page')

@section('title', 'Sparteoli')

@section('content_header')
    <h1>Vítima {{ $victim->name }}</h1>
@stop

@section('content')
    <div class="d-flex justify-content-between mb-5 flex-wrap">
        <a class="btn btn-info" href="{{ route('index-victim', ['occurrence_id' => $occurrence_id]) }}">
            <i class="fas fa-arrow-left"></i>
            Voltar
        </a>
        <div class="d-flex">
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
    <div class="d-flex justify-content-center">
        <div class="list-group col-md-8">
            @include('errors', ['errors' => $errors])
            <div class="list-group-item">
                <div class="d-flex w-100 justify-content-between flex-wrap">
                    <h5 class="mb-1 font-weight-bold">Informações:</h5>
                    <small>Última alteração: {{ date( 'd\/m\/Y - H:i', strtotime($victim->update_at)) }}</small>
                </div>
                <div class="mb-1 font-weight-normal">
                    <ul>
                        <li>
                            Idade: {{ $victim->age }}
                        </li>
                        <li>
                            Sexo: {{ $victim->sex == 'M' ? 'Masculino' : 'Feminino' }}
                        </li>
                        <li>
                            Socorrista: {{ $victim->rescuer->name }}
                        </li>
                        <li>
                            Problemas:
                        @foreach($victim->problems as $problem)
                        <ul>
                            <li>
                                {{ $problem->name }}
                            </li>
                        </ul>
                        @endforeach
                        </li>
                    </ul>
                </div>
                <p>{{ $victim->fatal ? 'Vítima fatal' : ($victim->conscious ? 'Vítima não fatal e consciente' : 'Vítima não fatal e não consciente') }}</p>
            </div>
        </div>
    </div>
@stop
