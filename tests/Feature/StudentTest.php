<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Student;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
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
}
