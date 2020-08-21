@extends('adminlte::page')

@section('title', 'Sparteoli')

@section('content_header')
    <h1>Usuários</h1>
@stop

@section('content')
    <div class="container">
        <div class="d-flex justify-content-end mb-5">
            @can('admin')
                <a href="{{route('register')}}" class="btn btn-success">
                    <i class="fas fa-plus"></i> Adicionar
                </a>
            @endauth
        </div>
        <div class="d-flex justify-content-center">
            <div class="list-group col-md-8">
                @foreach($users as $user)
                    <div class="list-group-item d-flex justify-content-between align-content-center flex-wrap">
                        <a class="link-muted" href="{{ route('show-user', $user->id) }}">
                            <p class="mb-0">{{ $user->name }}</p>
                            <small>{{ $user->admin ? 'Administrador' : '' }}</small>
                        </a>
                        @can('admin')
                            <div class="d-flex justify-content-around">
                                <div>
                                    <a class="btn btn-primary mr-2" href="{{route('edit-user', $user->id)}}">
                                        <p class="mb-0">
                                            <i class="fas fa-edit"></i>
                                            Atualizar
                                        </p>
                                    </a>
                                </div>
                                <form method="post" action="{{ route('destroy-user', $user->id) }}"
                                      onsubmit="return confirm('Tem certeza que deseja remover {{addslashes( $user->name )}}?')">
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
