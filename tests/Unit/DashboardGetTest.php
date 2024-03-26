<?php

namespace Tests\Feature;

use App\Models\Exercise;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use Tests\TestCase;

class DashboardGetTest extends TestCase
{
    use RefreshDatabase;

    public function testGetDashboard()
    {
        // Preparação dos dados de exercício e usuário necessários
        // Exercise::factory()->count(5)->create();

        User::factory()->count(2)->create(['profile_id' => 1]);
        User::factory()->count(3)->create(['profile_id' => 2]);

        // Chama a rota que corresponde ao método getDashboard() do DashboardController
        $response = $this->get('/dashboard/admin');

        // Verifica se a resposta HTTP é 200 (OK)
        $response->assertStatus(Response::HTTP_OK);

        // Verifica se a resposta contém as chaves esperadas
        $response->assertJsonStructure([
            'registered_exercises',
            'profiles',
        ]);

        // Verifica se a quantidade de exercícios registrados está correta
        $response->assertJsonFragment([
            'registered_exercises' => 5,
        ]);

        // Verifica se os perfis de usuários e suas contagens estão corretos
        $response->assertJsonFragment([
            'profiles' => [
                'admin' => 2,
                'user' => 3,
            ],
        ]);

        // Outras asserções conforme necessário
    }
}
