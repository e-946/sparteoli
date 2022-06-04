@extends('adminlte::page')

@section('title', 'Sparteoli')

@section('content_header')
    <h1>Relatórios</h1>
@stop

@section('content')
    <table id="occurrences_table" class="table">
        <thead>
            <tr>
                <th>Bairro</th>
                <th>Data</th>
                <th>Turno</th>
                <th>Natureza</th>
                <th>Tipo</th>
                <th>Sexo</th>
                <th>Idade</th>
            </tr>
        </thead>
        <tbody class="font-weight-normal">
            @foreach($occurrences as $occurrence)
                <tr>
                    <th>{{ $occurrence->neighborhood }}</th>
                    <th>{{ $occurrence->date }}</th>
                    <th>{{ $occurrence->getShift() }}</th>
                    <th>{{ $occurrence->type->nature->name }}</th>
                    <th>{{ $occurrence->type->name }}</th>
                    <th>{{ !$occurrence->victims ? 'Sem vítimas' : (!$occurrence->victims->first() ? 'Sem vítimas' : ($occurrence->victims->first()->sex == 'M' ? 'Masculino' : 'Feminino')) }}</th>
                    <th>{{ !$occurrence->victims ? 'Sem vítimas' : (!$occurrence->victims->first() ? 'Sem vítimas' : $occurrence->victims->first()->getAgeRange()) }}</th>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <th>Bairro</th>
                <th>Data</th>
                <th>Turno</th>
                <th>Natureza</th>
                <th>Tipo</th>
                <th>Sexo</th>
                <th>Idade</th>
            </tr>
        </tfoot>
    </table>

    {{ $occurrences->links() }}
@endsection