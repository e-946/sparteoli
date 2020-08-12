@extends('adminlte::page')

@section('title', 'Fireforce')

@section('content_header')
    <h1>Adicionar Vítimas</h1>
@stop

@section('content')
    <a class="btn btn-info mb-5" href="{{ url()->previous() === route('show-occurrence', ['id' => $occurrence_id]) ? route('show-occurrence', ['id' => $occurrence_id]) : route('index-victim', ['occurrence_id' => $occurrence_id]) }}">
        <i class="fas fa-arrow-left"></i>
        Voltar
    </a>
    <form method="post">
        @csrf
        <div class="mb-2 mx-sm-3">
            <div class="form-row mb-3">
                <div class="col">
                    <label for="name" class="">Nome:</label>
                    <input id="name" type="text" name="name" class="form-control" placeholder="Nome" autofocus required>
                </div>
            </div>
            <div class="form-row mb-3">
                <div class="col-6">
                    <label for="age" class="">Idade:</label>
                    <input id="age" type="number" name="age" class="form-control" placeholder="Idade" required>
                </div>
                <div class="col-6">
                    <label for="sex" class="">Sexo:</label>
                    <select id="sex" type="number" name="sex" class="form-control" required>
                        <option selected class="text-bold" disabled>Selecione</option>
                        <option value="M">Masculino</option>
                        <option value="F">Feminino</option>
                    </select>
                </div>
            </div>
            <div class="form-row mb-3">
                <div class="col mr-3">
                    <label for="rescuer" class="">Socorrista:</label>
                    <select id="rescuer" type="number" name="rescuer_id" class="form-control" required>
                        <option selected class="text-bold" disabled>Selecione</option>
                        @foreach($rescuers as $rescuer)
                            <option value="{{ $rescuer->id }}">{{ $rescuer->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col text-left">
                    Problemas encontrados
                    <div class="form-check">
                        @foreach($problems as $problem)
                                <input id="{{ $problem->id }}" type="checkbox" name="problemForSave[]" class="form-check-input" value="{{ $problem->id }}">
                                <label for="{{ $problem->id }}" class="form-check-label">{{ $problem->name }}</label>
                            <br>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="form-row">
                <div class="col-6">
                    <label for="fatal" class="">Sobre a fatalidade: </label>
                    <select id="fatal" type="number" name="fatal" class="form-control" required onChange="ckChange()">
                        <option selected class="text-bold" disabled>Selecione</option>
                        <option value="1">Vítima fatal</option>
                        <option value="0">Vítima não fatal</option>
                    </select>
                </div>
                <div class="col-6">
                    <label for="conscious" class="">Sobre a consciência: </label>
                    <select id="conscious" type="number" name="conscious" class="form-control" required>
                        <option selected class="text-bold" disabled>Selecione</option>
                        <option value="1">Vítima consciente</option>
                        <option value="0">Vítima não consciente</option>
                    </select>
                </div>
            </div>
        </div>
        <button type="submit" class="btn btn-success mb-2">Salvar</button>
    </form>

    <script>
        function ckChange(){
            let fatal = document.getElementById('fatal');
            let forDisable = document.getElementById('conscious');
            if (fatal.options[fatal.selectedIndex].text === 'Vítima fatal') {
                forDisable.disabled = true;
                forDisable.value = null;
            } else {
                forDisable.disabled = false;
            }
        }
    </script>
@stop
