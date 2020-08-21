<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulário da ocorrência</title>

    <link rel="stylesheet" href="{{ asset('css/reset.css') }}">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">

    <style>
        body > div {
            width: 800px;
            padding: 20px;
        }

        table {
            width: 100%;
            margin: 0 auto;
        }

        table tr td p {
            font-size: 1.5em;
        }

        tr {
            border: black 1px solid;
            width: 100%;
            padding: 5px;
        }

        td {
            border: black 1px solid;
            padding: 10px;
        }

        h1, h2, h3, h4, h5, h6 {
            margin: 0.5rem;
            font-weight: bold;
            line-height: 1.2;
        }

        .break {
            break-before: page;
        }

    </style>

</head>
<body onload="window.print()">
<main class="container d-flex justify-content-center">
    <section>
        <header>
            <table class="text-center align-middle">
                <tr>
                    <td class="">
                        <h1>Formulário da ocorrência</h1>
                    </td>
                </tr>
            </table>
            <table class="text-center align-middle">
                <tr class="">
                    <td class="align-middle">
                        <img src="{{ asset('img/insignia.png') }}" width="100" alt="insígnia do 9º corpo de bombeiros">
                    </td>
                    <td class="align-middle">
                        <p class="mb-0">CORPO DE BOMBEIROS MILITAR DA BAHIA</p>
                        <p class="mb-0">9o GRUPAMENTO DE BOMBEIRO MILITAR</p>
                        <p class="mb-0">SEÇÃO DE PLANEJAMENTO OPERACIONAL</p>
                    </td>
                </tr>
            </table>
        </header>
        <article>
            <header>
                <table class="text-center align-middle">
                    <tr class="align-middle">
                        <td class="align-middle">
                            <h2>Identificação da ocorrência</h2>
                        </td>
                        <td class="align-middle">
                            <h3>Ocorrência Nº</h3> <p>{{ $occurrence->id }}</p>
                        </td>
                    </tr>
                </table>
            </header>
            <table class="text-center align-middle">
                <tr>
                    <td class="align-middle">
                        <h3>Data do chamado:</h3>
                        <p>{{ date( 'd\/m\/Y', strtotime($occurrence->date)) }}</p>
                    </td>
                    <td class="align-middle">
                        <h3>Horário do chamado:</h3>
                        <p>{{ $occurrence->call_time }}</p>
                    </td>
                    <td class="align-middle">
                        <h3>Horário da chegada:</h3>
                        <p>{{ $occurrence->arrival_time }}</p>
                    </td>
                    <td class="align-middle">
                        <h3>Horário de encerramento:</h3>
                        <p>{{ $occurrence->end_time }}</p>
                    </td>
                    <td class="align-middle">
                        <h3>Meio utilizado:</h3>
                        <p>{{ $occurrence->meanused->name }}</p>
                    </td>
                </tr>
            </table>
            <table class="text-center align-middle">
                <tr>
                    <td class="align-middle">
                        <h3>Natureza da ocorrência:</h3>
                        <p>{{ $occurrence->type->nature->name }}</p>
                    </td>
                    <td class="align-middle">
                        <h3>Tipo da ocorrência:</h3>
                        <p>{{ $occurrence->type->name }}</p>
                </tr>
            </table>
        </article>
        <article>
            <header>
                <table class="text-center align-middle">
                    <tr>
                        <td class="align-middle">
                            <h2>Solicitante</h2>
                        </td>
                    </tr>
                </table>
            </header>
            <table class="text-center align-middle">
                <tr>
                    <td class="align-middle">
                        <h3>Nome:</h3>
                        <p>{{ $occurrence->requester }}</p>
                    </td>
                    <td class="align-middle">
                        <h3>Telefone:</h3>
                        <p>{{ preg_replace('/(\d{2})(\d{1})(\d{4})(\d{4})/', '($1) $2 $3-$4', $occurrence->requester_phone) }}</p>
                    </td>
                </tr>
            </table>
        </article>
        <article>
            <header>
                <table class="text-center align-middle">
                    <tr>
                        <td class="align-middle">
                            <h2>Local da ocorrência</h2>
                        </td>
                    </tr>
                </table>
            </header>
            <table class="text-center align-middle">
                <tr>
                    <td class="align-middle">
                        <h3>Característica do local:</h3>
                        <p>{{ $occurrence->placefreature->name }}</p>
                    </td>
                    <td class="align-middle">
                        <h3>Uso do local:</h3>
                        <p>{{ $occurrence->placeuse->name }}</p>
                    </td>
                    <td class="align-middle">
                        <h3>Local de Preservação:</h3>
                        <p>{{ $occurrence->place_preservation == 1 ? 'Sim' : 'Não' }}</p>
                    </td>
                    <td class="align-middle">
                        <h3>Proteções contra incêndio:</h3>
                        <ul>
                            @foreach($occurrence->fireprotections as $protection)
                                <li>
                                    <p>{{ $protection->name }}</p>
                                </li>
                            @endforeach
                        </ul>
                    </td>
                </tr>
            </table>
            <table class="text-center align-middle">
                <tr>
                    <td class="align-middle">
                        <h3>Endereço:</h3>
                        <p>{{ $occurrence->address }}</p>
                    </td>
                    <td class="align-middle">
                        <h3>Bairro:</h3>
                        <p>{{ $occurrence->neighborhood }}</p>
                    </td>
                </tr>
            </table>
            <table class="text-center align-middle">
                <tr>
                    <td class="align-middle">
                        <h3>Cidade:</h3>
                        <p>{{ $occurrence->city }}</p>
                    </td>
                    <td class="align-middle">
                        <h3>Estado:</h3>
                        <p>{{ $occurrence->state }}</p>
                    </td>
                    <td class="align-middle">
                        <h3>CEP:</h3>
                        <p>{{ preg_replace('/(\d{2})(\d{3})(\d{3})/', '$1.$2-$3', $occurrence->zip_code) }}</p>
                    </td>
                </tr>
            </table>
        </article>
        <article
            @if ($occurrence->victims->count() > 2)
                class="break"
            @endif
        >
            <header>
                <table class="text-center align-middle">
                    <tr>
                        <td class="align-middle">
                            <h2>Vítimas</h2>
                        </td>
                    </tr>
                </table>
            </header>
            <table class="text-center align-middle">
                <tr>
                    <th>
                        Nome:
                    </th>
                    <th>
                        Socorrista:
                    </th>
                    <th>
                        Idade:
                    </th>
                    <th>
                        Sexo:
                    </th>
                    <th>
                        Consciente:
                    </th>
                    <th>
                        Fatal:
                    </th>
                    <th>
                        Problemas:
                    </th>
                </tr>
                @foreach($occurrence->victims as $victim)
                <tr>
                    <td class="align-middle">
                        {{ $victim->name }}
                    </td>
                    <td class="align-middle">
                        {{ $victim->rescuer->name }}
                    </td>
                    <td class="align-middle">
                        {{ $victim->age }}
                    </td>
                    <td class="align-middle">
                        {{ $victim->sex == 'M' ? 'Masculino' : 'Feminino' }}
                    </td>
                    <td class="align-middle">
                        {{ $victim->conscious ? 'Sim' : 'Não' }}
                    </td>
                    <td class="align-middle">
                        {{ $victim->fatal ? 'Sim' : 'Não' }}
                    </td>
                    <td class="align-middle">
                        <ul>
                            @foreach($victim->problems as $problem)
                                <li>
                                    {{ $problem->name }}
                                </li>
                            @endforeach
                        </ul>
                    </td>
                </tr>
                @endforeach
            </table>
        </article>
        <article
            @if ($occurrence->victims->count() <= 2)
                 class="break"
            @endif>
            <header>
                <table class="text-center align-middle">
                    <tr>
                        <td class="align-middle">
                            <h2>Recursos</h2>
                        </td>
                    </tr>
                </table>
            </header>
            <table class="text-center align-middle">
                <tr>
                    <th>
                        Quem:
                    </th>
                    <th>
                        O que:
                    </th>
                    <th>
                        Onde:
                    </th>
                    <th>
                        Como:
                    </th>
                </tr>
                <tr>
                    @foreach($occurrence->resources as $resource)
                    <td class="align-middle">
                        {{ $resource->who }}
                    </td>
                    <td class="align-middle">
                        {{ $resource->what }}
                    </td>
                    <td class="align-middle">
                        {{ $resource->where }}
                    </td>
                    <td class="align-middle">
                        {{ $resource->how }}
                    </td>
                    @endforeach
                </tr>
            </table>
        </article>
        <table class="text-center align-middle">
            <tr>
                <td class="align-middle">
                    <h3>Resumo:</h3>
                    <p>{{ $occurrence->resume }}</p>
                </td>
            </tr>
        </table>
        <article>
            <header>
                <table class="text-center align-middle">
                    <tr>
                        <td class="align-middle">
                            <h2>Preenchedor</h2>
                        </td>
                    </tr>
                </table>
            </header>
            <table class="text-center align-middle">
                <tr>
                    <td class="align-middle">
                        <h3>Nome:</h3>
                        <p>{{ $occurrence->filler_name }}</p>
                    </td>
                    <td class="align-middle">
                        <h3>Registro:</h3>
                        <p>{{ $occurrence->filler_register }}</p>
                    </td>
                    <td class="align-middle">
                        <h3>Patente</h3>
                        <p>{{ $occurrence->filler_patent }}</p>
                    </td>
                </tr>
            </table>
        </article>
    </section>
</main>
</body>
</html>
