<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Sua avaliação está aqui!</title>
    <style>
        h2{
            background-color: #424242;
            color: #ffffff;
            font-family: Arial, Helvetica, sans-serif;
            padding-top: 3px;
            padding-bottom: 2px;
            padding-left: 2px;
            font-size: 36px;
            font-weight: bold;
            text-align: center;
        }
        h3 {
            color: #ffc107;
            font-family: Arial, Helvetica, sans-serif
            font-size: 35px;
            font-weight: bold;
        }
        p {
            color: #212121;
            font-family: Arial, Helvetica, sans-serif
            font-size: 20px;
            text-align: justify;
        }
        table{
            font-family: Arial, Helvetica, sans-serif
            border-collapse: collapse;
            width: 100%
        }
        th{
            width: 70%;
            padding-bottomom: 3px;
        }
        td {
            width: 70%;
            padding-bottomom: 2px;
        }
        .title {
            background-color: #424242;
            color: #ffc107;
            font-size: 18px;
            font-weight: bold;
            text-align: center;
        }
        .info {
            background-color: #ffffff;
            color: #212121;
            font-size: 18px;
            text-align: center;
        }
    </style>
</head>
<body>
    {{-- <img src=""> --}}
    <h2>Veja os resultados da sua avaliação</h2>

    <p>Olá, ____________ </p>

    <p>Segue o resultado da avaliação que você realizou uma avaliação no dia _____________
        com a nossa equipe.</p>

    <br>
    <h3>Informações Gerais</h3>
    <table>
        <tr class="title">
            <th>Nome</th>
            <th>Idade</th>
            <th>Peso</th>
            <th>Altura</th>
        </tr>
        @foreach ($avaliations as $avaliation)
        <tr class="info">
            <td>Nome</td>
            <td>{{ $avaliation->age }}</td>
            <td>{{ $avaliation->weight }}</td>
            <td>{{ $avaliation->height }}</td>
        </tr>
        @endforeach
    </table>
    <br>
    <h3>Medidas</h3>
    <table>
        <tr class="title">
            <th>Medida1</th>
            <th>Medida2</th>
        </tr>
        <tr>
            <td class="title">Valor1</td>
            <td class="info">Medida1</td>
        </tr>
        <tr>
            <td class="title">Valor2</td>
            <td class="info">Medida2</td>
        </tr>
        <tr>
            <td class="title">Valor3</td>
            <td class="info">Medida3</td>
        </tr>
        <tr>
            <td class="title">Valor4</td>
            <td class="info">Medida4</td>
        </tr>
        <tr>
            <td class="title">Valor5</td>
            <td class="info">Medida5</td>
        </tr>
        <tr>
            <td class="title">Valor6</td>
            <td class="info">Medida6</td>
        </tr>
        <tr>
            <td class="title">Valor7</td>
            <td class="info">Medida7</td>
        </tr>
    </table>
</body>
</html>
