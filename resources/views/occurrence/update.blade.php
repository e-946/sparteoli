@extends('adminlte::page')

@section('title', 'Sparteoli')

@section('content_header')
    <h1>Alterar ocorrência {{ $occurrence->id }}:</h1>
@stop

@section('content')
    <a class="btn btn-info mb-5" href="{{ url()->previous() == route('show-occurrence', ['id' => $occurrence->id]) ? route('show-occurrence', ['id' => $occurrence->id]) : route('index-occurrence') }}">
        <i class="fas fa-arrow-left"></i>
        Voltar
    </a>
    <form method="post" class="" onsubmit="return confirm('Tem certeza que deseja atualizar {{addslashes( $occurrence->id )}}?')">
        @method('PUT')
        @csrf
        <div class="mb-2">
            <fieldset class="form-row mb-3">
                <legend>Data e chamado</legend>
                <div class="col-12 col-lg-6 mb-3">
                    <label for="date" class="">Data:</label>
                    <input id="date" type="date" name="date" class="form-control" autofocus required value="{{ $occurrence->date }}">
                </div>
                <div class="col-12 col-lg-6 mb-3">
                    <label for="call_time" class="">Horário do chamado:</label>
                    <input id="call_time" type="time" name="call_time" class="form-control" required value="{{ $occurrence->call_time }}">
                </div>
                <div class="col-12 col-lg-6 mb-3">
                    <label for="arrival_time" class="">Horário da chegada:</label>
                    <input id="arrival_time" type="time" name="arrival_time" class="form-control" required value="{{ $occurrence->arrival_time }}">
                </div>
                <div class="col-12 col-lg-6 mb-3">
                    <label for="end_time" class="">Horário do encerramento:</label>
                    <input id="end_time" type="time" name="end_time" class="form-control" required value="{{ $occurrence->end_time }}">
                </div>
                <div class="col-12 col-lg-6 mb-3">
                    <label for="meanused" class="">Meio de chamado utilizado:</label>
                    <select id="meanused" type="number" name="meanused_id" class="form-control" required>
                        <option selected class="text-bold" disabled>Selecione</option>
                        @foreach($means as $mean)
                            <option value="{{ $mean->id }}" {{ $occurrence->meanused->id === $mean->id ? 'selected' : '' }}>{{ $mean->name }}</option>
                        @endforeach
                    </select>
                </div>
            </fieldset>
            <fieldset class="form-row mb-3">
                <legend>Endereço</legend>
                <div class="col-12 col-lg-6 mb-3">
                    <label for="zip_code" class="">Cep:</label>
                    <input id="zip_code" type="text" name="zip_code" class="form-control" placeholder="CEP" pattern="[0-9]{8}" onblur="pesquisacep(this.value);" required value="{{ $occurrence->zip_code }}">
                </div>
                <div class="col-auto mt-3 mb-3">
                    <a target="_blank" href="http://www.buscacep.correios.com.br/sistemas/buscacep/" class="btn btn-info">
                        <i class="fa fa-search"></i>
                        Consultar CEP
                    </a>
                </div>
                <div class="col-12 col-lg-6 mb-3">
                    <label for="street" class="">Rua:</label>
                    <input id="street" type="text" name="street" class="form-control" placeholder="Rua" required value="{{ explode(', ',$occurrence->address)[0] }}">
                </div>
                <div class="col-12 col-lg-6 mb-3">
                    <label for="number" class="">Número:</label>
                    <input id="number" type="number" name="number" class="form-control" required value="{{ str_replace('Nº ','',explode(', ',$occurrence->address)[1]) }}">
                </div>
                <div class="col-12 col-lg-6 mb-3">
                    <label for="neighborhood" class="">Bairro:</label>
                    <input id="neighborhood" type="text" name="neighborhood" class="form-control" placeholder="Bairro" required value="{{ $occurrence->neighborhood }}">
                </div>
                <div class="col-12 col-lg-6 mb-3">
                    <label for="city" class="">Cidade:</label>
                    <input id="city" type="text" name="city" class="form-control" placeholder="Cidade" required value="{{ $occurrence->city }}">
                </div>
                <div class="col-12 col-lg-6 mb-3">
                    <label for="state" class="">Estado:</label>
                    <input id="state" type="text" name="state" class="form-control" placeholder="Estado" required value="{{ $occurrence->state }}">
                </div>
            </fieldset>
            <fieldset class="form-row mb-3">
                <legend>Solicitante</legend>
                <div class="col-12 col-lg-6 mb-3">
                    <label for="requester" class="">Nome:</label>
                    <input id="requester" type="text" name="requester" class="form-control" placeholder="Nome" required value="{{ $occurrence->requester }}">
                </div>
                <div class="col-12 col-lg-6 mb-3">
                    <label for="requester_phone" class="">Telefone:</label>
                    <input id="requester_phone" type="tel" pattern="\([0-9]{2}\)[0-9]{5}\-[0-9]{4}" name="requester_phone" class="form-control" placeholder="Telefone" required value="{{ $occurrence->requester_phone }}">
                </div>
            </fieldset>
            <fieldset class="form-row mb-3">
                <legend>Resumo</legend>
                <div class="col-12 mb-3">
                    <label for="resume" class="">Detalhes da ocorrência: </label>
                    <textarea id="resume" name="resume" class="form-control" form="form" required>{{ $occurrence->resume }}</textarea>
                </div>
            </fieldset>
            <fieldset class="form-row mb-3">
                <legend>Local</legend>
                <div class="col-12 col-lg-6 mb-3">
                    <label for="placefreature" class="">Caracteristica do local:</label>
                    <select id="placefreature" type="number" name="placefreature_id" class="form-control" required>
                        <option class="text-bold" disabled>Selecione</option>
                        @foreach($freatures as $freature)
                            <option value="{{ $freature->id }}" {{ $occurrence->placefreature->id === $freature->id ? 'selected' : '' }}>{{ $freature->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-12 col-lg-6 mb-3">
                    <label for="placeuse" class="">Uso do local:</label>
                    <select id="placeuse" type="number" name="placeuse_id" class="form-control" required>
                        <option selected class="text-bold" disabled>Selecione</option>
                        @foreach($uses as $use)
                            <option value="{{ $use->id }}" {{ $occurrence->placeuse->id === $use->id ? 'selected' : '' }}>{{ $use->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-12 col-lg-6 mb-3">
                    <label for="place_preservation" class="">É local de presevação:</label>
                    <select id="place_preservation" type="number" name="place_preservation" class="form-control" required>
                        <option class="text-bold" disabled>Selecione</option>
                        <option value="1" {{ $occurrence->place_preservation === 1 ? 'selected' : '' }}>Sim</option>
                        <option value="2" {{ $occurrence->place_preservation === 2 ? 'selected' : '' }}>Não</option>
                    </select>
                </div>
            </fieldset>
            <fieldset class="form-row mb-3">
                <legend>Preenchedor</legend>
                <div class="col-12 col-lg-6 mb-3">
                    <label for="filler_register" class="">Matrícula: </label>
                    <input id="filler_register" onblur="searchFiller(this.value)" type="text" max="10" name="filler_register" class="form-control" placeholder="Registro" required value="{{ $occurrence->filler_register }}">
                </div>
                <div class="col-12 col-lg-6 mb-3">
                    <label for="filler_name" class="">Nome: </label>
                    <input id="filler_name" type="text" name="filler_name" class="form-control" placeholder="Nome" required value="{{ $occurrence->filler_name }}">
                </div>
                <div class="col-12 col-lg-6 mb-3">
                    <label for="filler_patent" class="">Posto/Graduação: </label>
                    <input id="filler_patent" type="text" name="filler_patent" class="form-control" placeholder="Patente" required value="{{ $occurrence->filler_patent }}">
                </div>
            </fieldset>
            <fieldset class="form-row mb-3">
                <legend>Operação</legend>
                <div class="col-12 col-lg-6 mb-3">
                    <label for="type_id" class="">O tipo da operação</label>
                    <select id="type_id" type="number" name="type_id" class="form-control" required>
                        <option class="text-weight-bold" disabled>Selecione</option>
                        @foreach($natures as $nature)
                            <option class="text-bold" disabled>{{ $nature->name }}</option>
                            @foreach($nature->types as $type)
                                <option class="text-weight-normal" value="{{ $type->id }}" {{ $occurrence->type->id === $type->id ? 'selected' : '' }}>{{ $type->name }}</option>
                            @endforeach
                        @endforeach
                    </select>
                </div>
            </fieldset>
            <fieldset class="form-row mb-3">
                <legend>Proteção contra incêndios</legend>
                <div class="col">
                    @foreach($protections as $protection)
                        <input id="{{ $protection->id }}" type="checkbox" name="protectionsForSave[]" class="" value="{{ $protection->id }}"
                        @foreach($occurrence->fireprotections as $checkedProtection)
                            {{ $checkedProtection->id == $protection->id ? 'checked' : '' }}
                            @endforeach>
                        <label for="{{ $protection->id }}" class="">{{ $protection->name }}</label>
                        <br>
                    @endforeach
                </div>
            </fieldset>
            <div class="m-2">
                <label for="user_id" class="">Usuário: </label>
                <p class="font-weight-normal">{{ $occurrence->user->name }}</p>
                <input id="user_id" type="text" name="user_id" class="form-control" value="{{ $occurrence->user->id }}" hidden readonly>
            </div>
        </div>
        <button type="submit" class="btn btn-success mb-2">Salvar</button>
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
            if (cep !== "") {

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
        }

        const fillers = @json($fillers);

        function cleanFillerForm() {
            document.getElementById('filler_name').value=("");
            document.getElementById('filler_patent').value=("");
        }

        function searchFiller(value) {
            if (value === '') {
                return void(0)
            }

            let result = fillers.filter(function (item) {
                return value === item.filler_register
            })

            if (!result && result.length === 0) {
                return void(0)
            }

            cleanFillerForm();

            let item = result[0];

            document.getElementById('filler_name').value=(item.filler_name);
            document.getElementById('filler_patent').value=(item.filler_patent);
        }

    </script>
@stop
