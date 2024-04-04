<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bem-vindo ao FITMANAGE TECH</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f5f5f5;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 800px;
            margin: 20px auto;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .bgcolor {
            display: flex;
            flex-direction: column;
            align-items: center;
            width: 100%;
            height: 100%;
            padding: 30px 0px;
            border-radius: 8px 8px 0px 0px;
            background-color: #424242;
        }

        .logo {
            max-width: 250px;
            margin-bottom: 10px;
        }

        .logoSecundario {
            max-width: 150px;
            margin-bottom: 10px;
        }

        .welcome-text {
            font-size: 1.5rem;
            font-weight: bold;
            color: white;
            margin: 0px;
        }

        .info {
            width: 75%;
            margin: 0 auto;
            padding: 30px 0px 0px;
        }

        .welcomeMessage {
            font-size: 1.2rem;
            color: #555;
            margin-bottom: 30px;
        }

        .perfil-info {
            font-size: 1rem;
            color: #555;
        }

        .bold {
            font-weight: bold;
        }

        .margin {
            margin-top: 30px;
            margin-bottom: 0px;
        }

        .big {
            font-size: 1.5rem;
            margin-bottom: 40px;
        }

        .buttonAcess {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .cta-button {
            display: inline-block;
            padding: 10px 20px;
            background-color: #ffc107;
            color: #333;
            text-decoration: none;
            border-radius: 4px;
            font-weight: bold;
            transition: background-color 0.3s;
            margin-bottom: 40px;
        }

        .cta-button:hover {
            background-color: #e0a800;
        }

        .footer {

            margin-top: 30px;
            text-align: left;
            font-size: 0.8rem;
            color: #777;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }

        .footer a {
            color: #777;
            text-decoration: none;
            margin-right: 15px;
        }

        .footer a:hover {
            color: #333;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class ="bgcolor">
            <img class="logo" src="{{ $message->embed(public_path('fit-manage-tech.svg')) }}"
                alt="Logo FITMANAGE TECH completo">
            <p class="welcome-text">Bem-vindo, {{ $userName }}!</p>
        </div>

        <div class="info">
            <p class="welcomeMessage">Nós, do time FITMANAGE TECH estamos felizes em ter você conosco.</p>
            <p class="perfil-info">O perfil escolhido foi: <b>{{ $userProfile }}.</b>

            <div class="buttonAcess">
                <p class="perfil-info bold margin">Comece a usar todos seus benefícios agora mesmo!</p>
                <p class="perfil-info">Utilize a <b>senha</b> abaixo para acessar sua conta: </p>
                <p class="perfil-info bold big">{{ $password }}</p>

                <a class="cta-button" href="http://localhost:5173/">Faça seu login</a>
            </div>

        </div>
    </div>
    <div class="footer">
        <img class="logoSecundario" src="{{ $message->embed(public_path('logo.svg')) }}" alt="Logo FITMANAGE TECH">
        <div>
            <a href="#">Facebook</a>
            <a href="#">Twitter</a>
            <a href="#">Instagram</a>

        </div>
        <br>
        <p>&copy; {{ date('Y') }} FITMANAGE TECH. Todos os direitos reservados.</p>
        <div>
            <a href="#">Unsubscribe</a>
            <a href="#">Preferences</a>
            <a href="#">View in browser</a>
        </div>
</body>

</html>
