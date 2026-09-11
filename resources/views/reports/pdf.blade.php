<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Relatório de ocorrências</title>

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            font-size: 10px;
        }

        @page {
            size: A4 landscape;
            margin: 10mm;
        }

        h1 {
            font-size: 1.4em;
            margin-bottom: 10px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            border: black 1px solid;
            padding: 4px 6px;
            overflow-wrap: break-word;
            word-wrap: break-word;
            text-align: left;
        }

        th {
            background-color: #eee;
        }
    </style>
</head>
<body>
<h1>Relatório de ocorrências</h1>

<table>
    <thead>
        <tr>
            <th>ID</th>
            @foreach ($fields as $field)
                <th>{{ \App\Support\OccurrenceReportFields::label($field) }}</th>
            @endforeach
        </tr>
    </thead>
    <tbody>
        @foreach ($occurrences as $occurrence)
            <tr>
                <td>{{ $occurrence->id }}</td>
                @foreach ($fields as $field)
                    <td>{{ \App\Support\OccurrenceReportFields::value($occurrence, $field) }}</td>
                @endforeach
            </tr>
        @endforeach
    </tbody>
</table>
</body>
</html>
