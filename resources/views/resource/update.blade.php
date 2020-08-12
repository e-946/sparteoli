@extends('adminlte::page')

@section('title', 'Fireforce')

@section('content_header')
    <h1>Alterar vítima:</h1>
@stop

@section('content')
    <a class="btn btn-info mb-5" href="{{ url()->previous() === route('show-victim', ['occurrence_id' => $occurrence_id, 'id' => $victim->id]) ? route('show-victim', ['occurrence_id' => $occurrence_id, 'id' => $victim->id]) : route('index-victim', ['occurrence_id' => $occurrence_id]) }}">
        <i class="fas fa-arrow-left"></i>
        Voltar
    </a>
    <form method="post" class="" onsubmit="return confirm('Tem certeza que deseja atualizar {{addslashes( $victim->name )}}?')">
        @method('PUT')
        @csrf
        <div class="mb-2 mx-sm-3">
            <div class="form-row mb-3">
                <div class="col">
                    <label for="name" class="">Nome:</label>
                    <input id="name" type="text" name="name" class="form-control" placeholder="Nome" value="{{ $victim->name }}" autofocus required>
                </div>
            </div>
            <div class="form-row mb-3">
                <div class="col-4">
                    <label for="age" class="">Idade:</label>
                    <input id="age" type="number" name="age" class="form-control" placeholder="Idade" value="{{ $victim->age }}" required>
                </div>
                <div class="col-4">
                    <label for="sex" class="">Sexo:</label>
                    @if($victim->sex == 'M')
                        <select id="sex" type="number" name="sex" class="form-control" required>
                            <option class="text-bold" disabled>Selecione</option>
                            <option selected value="M">Masculino</option>
                            <option value="F">Feminino</option>
                        </select>
                    @else
                        <select id="sex" type="number" name="sex" class="form-control" required>
                            <option class="text-bold" disabled>Selecione</option>
                            <option value="M">Masculino</option>
                            <option selected value="F">Feminino</option>
                        </select>
                    @endif
                </div>
            </div>
            <div class="form-row mb-3">
                <div class="col mr-3">
                    <label for="rescuer" class="">Socorrista:</label>
                    <select id="rescuer" type="number" name="rescuer_id" class="form-control" required>
                        <option class="text-bold" disabled>Selecione</option>
                        @foreach($rescuers as $rescuer)
                            <option {{ $victim->rescuer->id == $rescuer->id ? 'selected' : '' }} value="{{ $rescuer->id }}">{{ $rescuer->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col text-left">
                    Problemas encontrados
                    <div class="form-check">
                        @foreach($problems as $problem)
                            <input id="{{ $problem->id }}" type="checkbox" name="problemForSave[]" class="form-check-input" value="{{ $problem->id }}"
                                @foreach($victim->problems as $checkedProblem)
                                    {{ $checkedProblem->id == $problem->id ? 'checked' : '' }}
                                @endforeach
                                >
                            <label for="{{ $problem->id }}" class="form-check-label">{{ $problem->name }}</label>
                            <br>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="form-row">
                <div class="col-4">
                    <label for="fatal" class="">Sobre a fatalidade: </label>
                    <select id="fatal" type="number" name="fatal" class="form-control" required onChange="ckChange()">
                        <option class="text-bold" disabled>Selecione</option>
                        @if( $victim->fatal == 1 )
                            <option selected value="1">Vítima fatal</option>
                            <option value="0">Vítima não fatal</option>
                        @else
                            <option value="1">Vítima fatal</option>
                            <option selected value="0">Vítima não fatal</option>
                        @endif
                    </select>
                </div>
                <div class="col-4">
                    <label for="conscious" class="">Sobre a consciência: </label>
                    @if( $victim->fatal == 1 )
                    <select id="conscious" type="number" name="conscious" class="form-control" required disabled>
                        <option class="text-bold" disabled>Selecione</option>
                        @if($victim->consious == 1)
                            <option selected value="1">Vítima consciente</option>
                            <option value="0">Vítima não consciente</option>
                        @else
                            <option value="1">Vítima consciente</option>
                            <option selected value="0">Vítima não consciente</option>
                        @endif
                    </select>
                    @else
                        <select id="conscious" type="number" name="conscious" class="form-control" required>
                            <option class="text-bold" disabled>Selecione</option>
                            @if($victim->consious == 1)
                                <option selected value="1">Vítima consciente</option>
                                <option value="0">Vítima não consciente</option>
                            @else
                                <option value="1">Vítima consciente</option>
                                <option selected value="0">Vítima não consciente</option>
                            @endif
                        </select>
                    @endif
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
