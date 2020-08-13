@extends('adminlte::page')

@section('title', 'Fireforce')

@section('content_header')
    <h1>Ocorrência {{ $occurrence->id }}</h1>
@stop

@section('content')
    <div class="d-flex justify-content-between mb-5 flex-wrap">
        <a class="btn btn-info" href="{{ route('index-occurrence') }}">
            <i class="fas fa-arrow-left"></i>
            Voltar
        </a>
        <div class="d-flex">
            <a class="btn btn-primary mr-2" href="{{route('edit-occurrence', $occurrence->id)}}">
                <p class="mb-0">
                    <i class="fas fa-edit"></i>
                    Atualizar
                </p>
            </a>
            @if ($occurrence->victims->count() > 0)
                <a class="btn btn-success mr-2" href="{{route('index-victim', ['occurrence_id' => $occurrence->id])}}">
                    <p class="mb-0">
                        <i class="fas fa-medkit"></i>
                        Listar Vítimas
                    </p>
                </a>
            @else
                <a class="btn btn-success mr-2" href="{{route('create-victim', ['occurrence_id' => $occurrence->id])}}">
                    <p class="mb-0">
                        <i class="fas fa-plus"></i>
                        Adicionar Vítimas
                    </p>
                </a>
            @endif

            @if ($occurrence->resources->count() > 0)
                <a class="btn btn-success mr-2" href="{{route('index-resource', ['occurrence_id' => $occurrence->id])}}">
                    <p class="mb-0">
                        <i class="fas fa-hands-helping"></i>
                        Listar Recursos
                    </p>
                </a>
            @else
                <a class="btn btn-success mr-2" href="{{route('create-resource', ['occurrence_id' => $occurrence->id])}}">
                    <p class="mb-0">
                        <i class="fas fa-plus"></i>
                        Adicionar Recursos
                    </p>
                </a>
            @endif

            <form method="post" action="{{ route('destroy-occurrence', $occurrence->id) }}"
                  onsubmit="return confirm('Tem certeza que deseja remover {{addslashes( $occurrence->name )}}?')">
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
            <pre>
                {{ var_dump($occurrence->fireprotections) }}
            </pre>
            <div class="list-group-item">
                <div class="d-flex w-100 justify-content-between flex-wrap">
                    <h5 class="mb-1 font-weight-bold">Informações:</h5>
                    <small>Última alteração: {{ date( 'd\/m\/Y - H:i', mktime($occurrence->update_at)) }}</small>
                </div>
                <div class="mb-1 font-weight-normal">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                            <tr>
                                <td>Campo</td>
                                <td>Dado Preenchido</td>
                            </tr>
                            </thead>
                            <tbody class="font-weight-normal">
                            @foreach($occurrence->toArray() as $key => $value)
                                <tr>
                                    @if (!is_array($value))
                                        <td>{{ $key }}</td>
                                        <td>{{ $value }}</td>
                                    @endif
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    @foreach($occurrence->victims as $victim)
                        <h5 class="mb-1 font-weight-bold">Vítima:</h5>
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                <tr>
                                    <td>Campo</td>
                                    <td>Dado Preenchido</td>
                                </tr>
                                </thead>
                                <tbody class="font-weight-normal">
                                @foreach($victim->toArray() as $key => $value)
                                    <tr>
                                        <td>{{ $key }}</td>
                                        <td>{{ $value }}</td>
                                    </tr>
                                @endforeach
                                <tr>
                                    <td>
                                        Problemas
                                    </td>
                                    <td>
                                        <ul>
                                @foreach($victim->problems as $problem)
                                            <li>
                                                {{ $problem->name }}
                                            </li>
                                @endforeach
                                        </ul>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@stop
