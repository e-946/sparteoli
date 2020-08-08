@extends('adminlte::page')

@section('title', 'Fireforce')

@section('content_header')
    <h1>Adicionar Ocorrência</h1>
@stop

@section('content')
    <a class="btn btn-info mb-5" href="{{ url()->previous() }}">
        <i class="fas fa-arrow-left"></i>
        Voltar
    </a>
    <form method="post" id="form">
        @csrf
        <div class="mb-2 mx-sm-3">
            <fieldset class="form-row mb-5">
                <legend>Data e chamado</legend>
                <div class="col-auto">
                    <label for="date" class="">Data:</label>
                    <input id="date" type="date" name="date" class="form-control" autofocus required>
                </div>
                <div class="col-auto">
                    <label for="call_time" class="">Horário do chamado:</label>
                    <input id="call_time" type="time" name="call_time" class="form-control" autofocus required>
                </div>
                <div class="col-auto">
                    <label for="arrival_time" class="">Horário da chegada:</label>
                    <input id="arrival_time" type="time" name="arrival_time" class="form-control" autofocus required>
                </div>
                <div class="col-auto">
                    <label for="end_time" class="">Horário do encerramento:</label>
                    <input id="end_time" type="time" name="end_time" class="form-control" autofocus required>
                </div>
                <div class="col-auto">
                    <label for="meanused" class="">Meio de chamado utilizado:</label>
                    <select id="meanused" type="number" name="meanused_id" class="form-control" required>
                        <option selected class="text-bold" disabled>Selecione</option>
                        @foreach($means as $mean)
                            <option value="{{ $mean->id }}">{{ $mean->name }}</option>
                        @endforeach
                    </select>
                </div>
            </fieldset>
            <fieldset class="form-row mb-5">
                <legend>Endereço</legend>
                <div class="col-auto">
                    <label for="zip_code" class="">Cep:</label>
                    <input id="zip_code" type="text" name="zip_code" class="form-control" placeholder="CEP" pattern="[0-9]{8}" onblur="pesquisacep(this.value);" required>
                </div>
                <div class="col-auto">
                    <label for="street" class="">Rua:</label>
                    <input id="street" type="text" name="street" class="form-control" placeholder="Rua" required>
                </div>
                <div class="col-auto">
                    <label for="number" class="">Número:</label>
                    <input id="number" type="number" name="number" class="form-control" required>
                </div>
                <div class="col-auto">
                    <label for="neighborhood" class="">Bairro:</label>
                    <input id="neighborhood" type="text" name="neighborhood" class="form-control" placeholder="Bairro" required>
                </div>
                <div class="col-auto">
                    <label for="city" class="">Cidade:</label>
                    <input id="city" type="text" name="city" class="form-control" placeholder="Cidade" required>
                </div>
                <div class="col-auto">
                    <label for="state" class="">Estado:</label>
                    <input id="state" type="text" name="state" class="form-control" placeholder="Estado" required>
                </div>
            </fieldset>
            <fieldset class="form-row mb-5">
                <legend>Solicitante</legend>
                <div class="col">
                    <label for="requester" class="">Nome:</label>
                    <input id="requester" type="text" name="requester" class="form-control" placeholder="Nome" required>
                </div>
                <div class="col">
                    <label for="requester_phone" class="">Telefone:</label>
                    <input id="requester_phone" type="tel" pattern="\([0-9]{2}\)[0-9]{5}\-[0-9]{4}" name="requester_phone" class="form-control" placeholder="Telefone" required>
                </div>
            </fieldset>
            <fieldset class="form-row mb-5">
                <legend>Resumo</legend>
                <div class="col">
                    <label for="resume" class="">Detalhes da ocorrência: </label>
                    <textarea id="resume" name="resume" class="form-control" form="form"></textarea>
                </div>
            </fieldset>
            <fieldset class="form-row mb-5">
                <legend>Local</legend>
                <div class="col">
                    <label for="placefreature" class="">Caracteristica do local:</label>
                    <select id="placefreature" type="number" name="placefreature_id" class="form-control" required>
                        <option selected class="text-bold" disabled>Selecione</option>
                        @foreach($freatures as $freature)
                            <option value="{{ $freature->id }}">{{ $freature->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col">
                    <label for="placeuse" class="">Uso do local:</label>
                    <select id="placeuse" type="number" name="placeuse_id" class="form-control" required>
                        <option selected class="text-bold" disabled>Selecione</option>
                        @foreach($uses as $use)
                            <option value="{{ $use->id }}">{{ $use->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col">
                    <label for="place_preservation" class="">É local de presevação:</label>
                    <select id="place_preservation" type="number" name="place_preservation" class="form-control" required>
                        <option selected class="text-bold" disabled>Selecione</option>
                        <option value="1">Sim</option>
                        <option value="2">Não</option>
                    </select>
                </div>
            </fieldset>
            <fieldset class="form-row mb-5">
                <legend>Preenchedor</legend>
                <div class="col">
                    <label for="filler_name" class="">Nome: </label>
                    <input id="filler_name" type="text" name="filler_name" class="form-control" placeholder="Nome" required>
                </div>
                <div class="col">
                    <label for="filler_register" class="">Registro: </label>
                    <input id="filler_register" type="text" max="10" name="filler_register" class="form-control" placeholder="Registro" required>
                </div>
                <div class="col">
                    <label for="filler_patent" class="">Patente: </label>
                    <input id="filler_patent" type="text" name="filler_patent" class="form-control" placeholder="Patente" required>
                </div>
            </fieldset>
            <fieldset class="form-row mb-5">
                <legend>Operação</legend>
                <div class="col">
                    <label for="type_id" class="">O tipo da operação</label>
                    <select id="type_id" type="number" name="type_id" class="form-control" required>
                        <option selected class="text-weight-bold" disabled>Selecione</option>
                        @foreach($natures as $nature)
                            <option class="text-bold" disabled>{{ $nature->name }}</option>
                            @foreach($nature->types as $type)
                                <option class="text-weight-normal" value="{{ $type->id }}">{{ $type->name }}</option>
                            @endforeach
                        @endforeach
                    </select>
                </div>
            </fieldset>
            <div class="m-5">
                <label for="user_id" class="">Usuário: </label>
                <p class="font-weight-normal">{{ \Illuminate\Support\Facades\Auth::user()->name }}</p>
                <input id="user_id" type="text" name="user_id" class="form-control" value="{{ \Illuminate\Support\Facades\Auth::user()->getAuthIdentifier() }}" hidden readonly>
            </div>
        </div>
        <button type="submit" class="btn btn-success mb-2">Pŕoxima etapa</button>
    </form>

    <script>

        function limpa_formulario_cep() {
            //Limpa valores do formulário de cep.
            document.getElementById('street').value=("");
            document.getElementById('neighborhood').value=("");
            document.getElementById('city').value=("");
            document.getElementById('state').value=("");
        }

        function meu_callback(conteudo) {
            if (!("erro" in conteudo)) {
                //Atualiza os campos com os valores.
                this.limpa_formulario_cep();
                document.getElementById('street').value=(conteudo.logradouro);
                document.getElementById('neighborhood').value=(conteudo.bairro);
                document.getElementById('city').value=(conteudo.localidade);
                document.getElementById('city').readOnly=true;
                document.getElementById('state').value=(conteudo.uf);
                document.getElementById('state').readOnly=true;

            } //end if.
            else {
                //CEP não Encontrado.
                limpa_formulario_cep();
                alert("CEP não encontrado.");
            }
        }

        function pesquisacep(valor) {

            //Nova variável "cep" somente com dígitos.
            var cep = valor.replace(/\D/g, '');

            //Verifica se campo cep possui valor informado.
            if (cep != "") {

                //Expressão regular para validar o CEP.
                var validacep = /^[0-9]{8}$/;

                //Valida o formato do CEP.
                if(validacep.test(cep)) {

                    //Preenche os campos com "..." enquanto consulta webservice.
                    document.getElementById('street').value="...";
                    document.getElementById('neighborhood').value="...";
                    document.getElementById('city').value="...";
                    document.getElementById('state').value="...";

                    //Cria um elemento javascript.
                    var script = document.createElement('script');

                    //Sincroniza com o callback.
                    script.src = 'https://viacep.com.br/ws/'+ cep + '/json/?callback=meu_callback';

                    //Insere script no documento e carrega o conteúdo.
                    document.body.appendChild(script);

                } //end if.
                else {
                    //cep é inválido.
                    limpa_formulario_cep();
                    alert("Formato de CEP inválido.");
                }
            } //end if.
            else {
                //cep sem valor, limpa formulário.
                limpa_formulario_cep();
            }
        };

    </script>
@stop
