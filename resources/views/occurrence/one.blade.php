@extends('adminlte::page')

@section('title', 'Fireforce')

@section('content_header')
    <h1>Ocorrência nº {{ $ocurrence->id }}</h1>
@stop

@section('content')
    <div class="d-flex justify-content-between mb-5 flex-wrap">
        <a class="btn btn-info" href="{{ url()->previous() }}">
            <i class="fas fa-arrow-left"></i>
            Voltar
        </a>
        <div class="d-flex">
            <a class="btn btn-primary mr-2" href="{{route('edit-ocurrence', $ocurrence->id)}}">
                <p class="mb-0">
                    <i class="fas fa-edit"></i>
                    Atualizar
                </p>
            </a>
            <form method="post" action="{{ route('destroy-ocurrence', $ocurrence->id) }}"
                  onsubmit="return confirm('Tem certeza que deseja remover {{addslashes( $ocurrence->name )}}?')">
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
            <div class="list-group-item">
                <div class="d-flex w-100 justify-content-between flex-wrap">
                    <h5 class="mb-1 font-weight-bold">Informações:</h5>
                    <small>Última alteração: {{ date( 'd\/m\/Y - H:i', mktime($ocurrence->update_at)) }}</small>
                </div>
                <p class="mb-1 font-weight-normal">Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                    Ut mattis sed dui quis tincidunt. Morbi ligula justo, luctus at nunc a, tincidunt ultrices nisi.
                    Duis ac tellus eleifend velit aliquam egestas. Donec ut rutrum tortor, in fermentum nisl.
                    Morbi et nisl sit amet justo viverra malesuada. Maecenas posuere bibendum tortor ac congue.
                    Aenean venenatis, dui sit amet molestie efficitur, sem dolor iaculis neque, a congue lacus metus eget purus.
                    Suspendisse ut consequat nulla. Duis metus erat, bibendum ac tincidunt ac, aliquet eu ipsum.
                    Aenean lobortis nunc et tellus condimentum, vel lacinia tortor blandit.
                    Ut vitae porttitor justo.</p>
                <small>Donec id elit non mi porta.</small>
            </div>
        </div>
    </div>
@stop
