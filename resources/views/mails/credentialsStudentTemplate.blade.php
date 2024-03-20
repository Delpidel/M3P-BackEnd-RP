<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Credenciais de Acesso</title>
</head>

<body>
    <p>Olá, {{ $student->name }}!</p>
    <p>Seu cadastro foi realizado com sucesso. Abaixo estão suas credenciais de acesso:</p>
    <ul>
        <li><strong>Email:</strong> {{ $student->email }}</li>
        <li><strong>Senha:</strong> {{ $password }}</li>
    </ul>
    <p>Por favor, faça login usando essas credenciais.</p>
    <p>Atenciosamente,<br> FitManage Tech</p>
</body>

</html>
