<?php

namespace Tests\Feature;

use App\Http\Services\Student\PasswordGenerationService;

use App\Models\User;

use Illuminate\Http\Request;
use Tests\TestCase;

class StudentTest extends TestCase
{
    public function test_receptionist_token_was_generated(): void
    {
        // Obtém o usuário da recepcionista existente
        $receptionist = User::find(2); // Assumindo que o ID da recepcionista é 2

        // Dados de login da recepcionista
        $credentials = [
            'email' => $receptionist->email,
            'password' => '12345678', // Senha da recepcionista
        ];

        // Faz uma requisição para a rota de login
        $response = $this->postJson('/api/login', $credentials);

        // Verifica se o login foi bem-sucedido (HTTP 200)
        $response->assertStatus(200);
    }

    public function test_request_body_all(): void
    {
        // Simula uma requisição HTTP com dados
        $body = [
            'name' => 'João da Silva',
            'email' => 'joao@example.com',
            'cpf' => '024.892.560-26',
            'date_birth' => '1945-01-24',
            'contact' => '980579171',
            'cep' => '96810174',
            'street' => 'Rua vinte e oito de setembro',
            'state' => 'RS',
            'neighborhood' => 'Centro',
            'city' => 'Santa cruz do sul',
            'number' => '642',
            // Adicione outros dados conforme necessário
        ];
        $request = new Request($body);

        // Faz a chamada para o método que queremos testar
        $result = $request->all();

        // Verifica se os dados da requisição foram corretamente capturados
        $this->assertEquals($body, $result);
    }

    public function test_password_is_being_generated(): void
    {
        // Cria uma instância do serviço de geração de senha
        $passwordGenerationService = new PasswordGenerationService();

        // Chama o método handle() para gerar uma senha
        $password = $passwordGenerationService->handle();

        // Verifica se a senha foi gerada corretamente
        $this->assertIsString($password); // Verifica se é uma string
        $this->assertGreaterThanOrEqual(8, strlen($password)); // Verifica se a senha tem pelo menos 8 caracteres
        // Adicione outras verificações conforme necessário, como caracteres especiais, etc.
    }
}
