@extends('adminlte::page')

@section('title', 'Sparteoli')

@section('content_header')
    <h1>Ocorrência {{ $occurrence->id }}</h1>
@stop

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-5 flex-wrap">
        <a class="btn btn-info m-2" href="{{ route('index-occurrence') }}">
            <i class="fas fa-arrow-left"></i>
            Voltar
        </a>
        <div class="d-flex justify-content-lg-around align-items-center m-1 flex-wrap">
            <a class="btn btn-primary m-1" href="{{route('edit-occurrence', $occurrence->id)}}">
                <p class="mb-0">
                    <i class="fas fa-edit"></i>
                    Atualizar
                </p>
            </a>
            <a class="btn btn-primary m-1" target="_blank" href="{{route('toPdf-occurrence', $occurrence->id)}}">
                <p class="mb-0">
                    <i class="fas fa-download"></i>
                    Baixar Pdf
                </p>
            </a>
            @if ($occurrence->victims->count() > 0)
                <a class="btn btn-success m-1" href="{{route('index-victim', ['occurrence_id' => $occurrence->id])}}">
                    <p class="mb-0">
                        <i class="fas fa-medkit"></i>
                        Listar Vítimas
                    </p>
                </a>
            @else
                <a class="btn btn-success m-1" href="{{route('create-victim', ['occurrence_id' => $occurrence->id])}}">
                    <p class="mb-0">
                        <i class="fas fa-plus"></i>
                        Adicionar Vítimas
                    </p>
                </a>
            @endif

            @if ($occurrence->resources->count() > 0)
                <a class="btn btn-success m-1" href="{{route('index-resource', ['occurrence_id' => $occurrence->id])}}">
                    <p class="mb-0">
                        <i class="fas fa-hands-helping"></i>
                        Listar Recursos
                    </p>
                </a>
            @else
                <a class="btn btn-success m-1" href="{{route('create-resource', ['occurrence_id' => $occurrence->id])}}">
                    <p class="mb-0">
                        <i class="fas fa-plus"></i>
                        Adicionar Recursos
                    </p>
                </a>
            @endif

            <form method="post" class="m-1" action="{{ route('destroy-occurrence', $occurrence->id) }}"
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
            @include('message', ['message' => $message ?? ''])
            <div class="list-group-item">
                <div class="d-flex w-100 justify-content-between flex-wrap">
                    <h5 class="mb-1 font-weight-bold">Informações:</h5>
                    <small>Última alteração: {{ date( 'd\/m\/Y - H:i', mktime($occurrence->update_at)) }}</small>
                </div>
                <div class="mt-3 mb-1 font-weight-normal">
                    <h5>Detalhes do chamado</h5>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Campo</th>
                                    <th>Dado Preenchido</th>
                                </tr>
                            </thead>
                            <tbody class="font-weight-normal">
                                <tr>
                                    <td>Data do chamado</td>
                                    <td>{{ date( 'd\/m\/Y', strtotime($occurrence->date)) }}</td>
                                </tr>
                                <tr>
                                    <td>Horário do chamado</td>
                                    <td>{{ $occurrence->call_time }}</td>
                                </tr>
                                <tr>
                                    <td>Horário de chegada</td>
                                    <td>{{ $occurrence->arrival_time }}</td>
                                </tr>
                                <tr>
                                    <td>Horário de encerramento</td>
                                    <td>{{ $occurrence->end_time }}</td>
                                </tr>
                                <tr>
                                    <td>Meio utilizado no chamado</td>
                                    <td>{{ $occurrence->meanused->name }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <h5>Endereço</h5>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                            <tr>
                                <th>Campo</th>
                                <th>Dado Preenchido</th>
                            </tr>
                            </thead>
                            <tbody class="font-weight-normal">
                            <tr>
                                <td>Endereço</td>
                                <td>{{ $occurrence->address }}</td>
                            </tr>
                            <tr>
                                <td>Bairro</td>
                                <td>{{ $occurrence->neighborhood }}</td>
                            </tr>
                            <tr>
                                <td>CEP</td>
                                <td>{{ preg_replace('/(\d{2})(\d{3})(\d{3})/', '$1.$2-$3', $occurrence->zip_code) }}</td>
                            </tr>
                            <tr>
                                <td>Cidade</td>
                                <td>{{ $occurrence->city }}</td>
                            </tr>
                            <tr>
                                <td>Estado</td>
                                <td>{{ $occurrence->state }}</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                    <h5>Solicitante</h5>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                            <tr>
                                <th>Campo</th>
                                <th>Dado Preenchido</th>
                            </tr>
                            </thead>
                            <tbody class="font-weight-normal">
                            <tr>
                                <td>Nome</td>
                                <td>{{ $occurrence->requester }}</td>
                            </tr>
                            <tr>
                                <td>Telefone</td>
                                <td>{{ preg_replace('/(\d{2})(\d{1})(\d{4})(\d{4})/', '($1) $2 $3-$4', $occurrence->requester_phone) }}</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                    <h5>Detalhes da ocorrência</h5>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                            <tr>
                                <th>Campo</th>
                                <th>Dado Preenchido</th>
                            </tr>
                            </thead>
                            <tbody class="font-weight-normal">
                            <tr>
                                <td>Tipo de Ocorrência</td>
                                <td>{{ $occurrence->type->name }}</td>
                            </tr>
                            <tr>
                                <td>Natureza da ocorrência</td>
                                <td>{{ $occurrence->type->nature->name }}</td>
                            </tr>
                            <tr>
                                <td>Resumo</td>
                                <td>{{ $occurrence->resume }}</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                    <h5>Detalhes do local</h5>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                            <tr>
                                <th>Campo</th>
                                <th>Dado Preenchido</th>
                            </tr>
                            </thead>
                            <tbody class="font-weight-normal">
                            <tr>
                                <td>Característica do local</td>
                                <td>{{ $occurrence->placefreature->name }}</td>
                            </tr>
                            <tr>
                                <td>Uso do local</td>
                                <td>{{ $occurrence->placeuse->name }}</td>
                            </tr>
                            <tr>
                                <td>Local de preservação</td>
                                <td>{{ $occurrence->place_preservation == 1 ? 'Sim' : 'Não' }}</td>
                            </tr><tr>
                                <td>Proteção contra incêndio</td>
                                <td>
                                    <ul>
                                        @foreach($occurrence->fireprotections as $protection)
                                            <li>
                                                <p>{{ $protection->name }}</p>
                                                <small>{{ $protection->desc }}</small>
                                            </li>
                                        @endforeach
                                    </ul>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                    <h5>Detalhes do preenchedor</h5>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                            <tr>
                                <th>Campo</th>
                                <th>Dado Preenchido</th>
                            </tr>
                            </thead>
                            <tbody class="font-weight-normal">
                            <tr>
                                <td>Nome</td>
                                <td>{{ $occurrence->filler_name }}</td>
                            </tr>
                            <tr>
                                <td>Registro</td>
                                <td>{{ $occurrence->filler_register }}</td>
                            </tr>
                            <tr>
                                <td>Patente</td>
                                <td>{{ $occurrence->filler_patent }}</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="mt-5 mb-1 font-weight-normal">
                    @foreach($occurrence->victims as $victim)
                        <h5 class="mb-1 font-weight-bold">Vítima:</h5>
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Campo</th>
                                        <th>Dado Preenchido</th>
                                    </tr>
                                </thead>
                                <tbody class="font-weight-normal">
                                    <tr>
                                        <td>Nome</td>
                                        <td>{{ $victim->name }}</td>
                                    </tr>
                                    <tr>
                                        <td>Idade</td>
                                        <td>{{ $victim->age }}</td>
                                    </tr>
                                    <tr>
                                        <td>Sexo</td>
                                        <td>{{ $victim->sex == 'M' ? 'Masculino' : 'Feminino' }}</td>
                                    </tr>
                                    <tr>
                                        <td>Situação</td>
                                        <td>{{ $victim->fatal ? 'Vítima fatal' : ($victim->conscious ? 'Vitima não fatal e consciente' : 'Vítima não fatal e não consciente') }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    @endforeach
                </div>
                <div class="mt-5 mb-1 font-weight-normal">
                    @foreach($occurrence->resources as $resource)
                        <h5 class="mb-1 font-weight-bold">Recurso:</h5>
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                <tr>
                                    <th>Campo</th>
                                    <th>Dado Preenchido</th>
                                </tr>
                                </thead>
                                <tbody class="font-weight-normal">
                                <tr>
                                    <td>De quem</td>
                                    <td>{{ $resource->who }}</td>
                                </tr>
                                <tr>
                                    <td>O que</td>
                                    <td>{{ $resource->what }}</td>
                                </tr>
                                <tr>
                                    <td>Onde</td>
                                    <td>{{ $resource->where }}</td>
                                </tr>
                                <tr>
                                    <td>Como</td>
                                    <td>{{ $resource->how }}</td>
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
