<!DOCTYPE html>
<html lang="pt-br">
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
        }
        td {
            width: 70%;
        }
        .title {
            background-color: #424242;
            color: #ffc107;
            font-size: 18px;
            font-weight: bold;
            text-align: center;
            border-bottom: 3px;
        }
        .info {
            background-color: #ffffff;
            color: #212121;
            font-size: 18px;
            text-align: center;
            border-bottom: 2px;
        }
    </style>
</head>

<body>
    <div class="container">

        <header>
            <h2>Veja os resultados da sua avaliação</h2>
        </header>

        <section>
            <p>Olá, {{ $studentName }} </p>

            <p>Vimos que você realizou uma avaliação no dia {{ $avaliationDate }} com a nossa equipe. Dito isso,
                gostaríamos de compartilhar com você o resultado dela:</p>
        </section>

        <br>

        <section>
            <h3>Informações Gerais</h3>
            {{-- <table>
                <tr class="title">
                    <th>Nome</th>
                    <th>Idade</th>
                    <th>Peso</th>
                    <th>Altura</th>
                </tr>
                <tr class="info">
                    <td>{{ $student->name }}</td>
                    <td>{{ $avaliation->age }}</td>
                    <td>{{ $avaliation->weight }}</td>
                    <td>{{ $avaliation->height }}</td>
                </tr>
            </table>
            <br>
            <h3>Medidas</h3>
            <table>
                <tr class="title">
                    <th>Medidas da Avaliação</th>
                    <th>Valores</th>
                </tr>
                <tr>
                    <td class="title">Tórax</td>
                    <td class="info">{{$avaliation->torax}}</td>
                </tr>
                <tr>
                    <td class="title">Braço Direito</td>
                    <td class="info">{{$avaliation->braco_direito}}</td>
                </tr>
                <tr>
                    <td class="title">Braço Esquerdo</td>
                    <td class="info">{{$avaliation->braco_esquerdo}}</td>
                </tr>
                <tr>
                    <td class="title">Cintura</td>
                    <td class="info">{{$avaliation->cintura}}</td>
                </tr>
                <tr>
                    <td class="title">Antebraço Direito</td>
                    <td class="info">{{$avaliation->antebraco_direito}}</td>
                </tr>
                <tr>
                    <td class="title">Antebraço Esquerdo</td>
                    <td class="info">{{$avaliation->antebraco_esquerdo}}</td>
                </tr>
                <tr>
                    <td class="title">Abdomen</td>
                    <td class="info">{{$avaliation->abdome}}</td>
                </tr>
                <tr>
                    <td class="title">Coxa Direita</td>
                    <td class="info">{{$avaliation->coxa_direita}}</td>
                </tr>
                <tr>
                    <td class="title">Coxa Esquerda</td>
                    <td class="info">{{$avaliation->coxa_esquerda}}</td>
                </tr>
                <tr>
                    <td class="title">Quadril</td>
                    <td class="info">{{$avaliation->quadril}}</td>
                </tr>
                <tr>
                    <td class="title">Panturrilha Direita</td>
                    <td class="info">{{$avaliation->panturrilha_direita}}</td>
                </tr>
                <tr>
                    <td class="title">Panturrilha Esquerda</td>
                    <td class="info">{{$avaliation->panturrilha_esquerda}}</td>
                </tr>
                <tr>
                    <td class="title">Punho</td>
                    <td class="info">{{$avaliation->punho}}</td>
                </tr>
                <tr>
                    <td class="title">Bíceps Femoral Direito</td>
                    <td class="info">{{$avaliation->b_femoral_direito}}</td>
                </tr>
                <tr>
                    <td class="title">Bíceps Femoral Esquerdo</td>
                    <td class="info">{{$avaliation->b_femoral_esquerdo}}</td>
                </tr>
            </table> --}}
        </section>

    </div>
</body>
</html>
