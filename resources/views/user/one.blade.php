@extends('adminlte::page')

@section('title', 'Sparteoli')

@section('content_header')
    <h1>{{$user->name}}</h1>
@stop

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-5 flex-wrap">
        <a class="btn btn-info m-2" href="{{ url()->previous() == route('index-user') ? route('index-user') : (url()->previous() == route('home') ? route('home') : url()->previous())}}">
            <i class="fas fa-arrow-left"></i>
            Voltar
        </a>
        @can('admin')
            <div class="d-flex justify-content-around align-items-center m-2">
                <a class="btn btn-primary mr-2" href="{{route('edit-user', $user->id)}}">
                    <p class="mb-0">
                        <i class="fas fa-edit"></i>
                        Atualizar
                    </p>
                </a>
                <a class="btn btn-primary mr-2" href="{{route('passwordId', $user->id)}}">
                    <p class="mb-0">
                        <i class="fas fa-key"></i>
                        Alterar Senha
                    </p>
                </a>
                @if($user->id !== Auth::id())
                <form method="post" action="{{ route('destroy-user', $user->id) }}"
                      onsubmit="return confirm('Tem certeza que deseja remover {{addslashes( $user->name )}}?')">
                    @method('DELETE')
                    @csrf
                    <button class="btn btn-danger">
                        <i class="fas fa-trash"></i>
                        Excluir
                    </button>
                </form>
                @endif
            </div>
        @endauth
    </div>
    <div class="d-flex justify-content-center">
        <div class="list-group col-md-8">
            @include('message', ['message' => $message ?? ''])
            <div class="list-group-item">
                <div class="d-flex w-100 justify-content-between flex-wrap">
                    <h5 class="mb-1 font-weight-bold">Informações:</h5>
                    <small>{{ $user->admin ? 'Administrador' : '' }}</small>
                    <small>Última alteração: {{ date( 'd\/m\/Y - H:i', strtotime($user->created_at)) }}</small>
                </div>
                <p class="mb-1 font-weight-normal">Usuário cadastrou {{ $user->occurrences->count() }} ocorrências</p>
                <small>Data de criação: {{ date( 'd\/m\/Y - H:i', strtotime($user->updated_at)) }}</small>
            </div>
        </div>
    </div>
@stop
