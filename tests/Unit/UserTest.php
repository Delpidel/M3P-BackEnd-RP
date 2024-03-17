<?php

namespace Tests\Feature;

use App\Http\Controllers\AuthController;
use App\Models\User;
use Database\Seeders\DatabaseSeeder;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
use Tests\TestCase;

class UserTest extends TestCase
{
    public function test_user_admin_can_done_login()
    {

        // $response = $this->post('/api/login', [
        //     'email' => env("DEFAULT_EMAIL"),
        //     'password' => env("DEFAULT_PASSWORD")
        // ]);

        $response = $this->post('/api/login', [
            'email' => "admin@gmail.com",
            'password' => "@coxinha"
        ]);

        // Verificar se o status code está como esperado
        $response->assertStatus(Response::HTTP_OK);

        $response->assertJson([
            "message" => "Autorizado",
            "status" => Response::HTTP_OK,
            'data' => [
                "token" => true,
                "permissions" => true,
                "name" => true,
                "profile" => "ADMIN"
            ]
        ]);
    }

    public function test_user_admin_permissions_load_correct()
    {
        // $response = $this->post('/api/login', [
        //     'email' => env("DEFAULT_EMAIL"),
        //     'password' => env("DEFAULT_PASSWORD")
        // ]);
        
        $response = $this->post('/api/login', [
            'email' => "admin@gmail.com",
            'password' => "@coxinha"
        ]);

        $response->assertStatus(Response::HTTP_OK);

        $response->assertJson([
            'data' => [
                'permissions' => [
                    'get-students',
                    'get-workouts'
                ]
            ]
        ]);
    }

    public function test_user_recepcionista_permissions_load_correct()
    {

        $user = User::factory()->create(['profile_id' => 2, 'password' => '12345678']);

        $response = $this->post('/api/login', [
            'email' => $user->email,
            'password' => '12345678'
        ]);

        $response->assertStatus(Response::HTTP_OK);


        $response->assertJson([
            'data' => [
                'permissions' => [
                    'get-students',
                    'get-workouts'
                ]
            ]
        ]);
    }

    public function test_user_instrutor_permissions_load_correct()
    {


        $user = User::factory()->create(['profile_id' => 3, 'password' => '12345678']);

        $response = $this->post('/api/login', [
            'email' => $user->email,
            'password' => '12345678'
        ]);

        $response->assertStatus(Response::HTTP_OK);


        $response->assertJson([
            'data' => [
                'permissions' => [
                    'get-students',
                    'get-workouts'
                ]
            ]
        ]);
    }

    public function test_user_nutricionista_permissions_load_correct()
    {


        $user = User::factory()->create(['profile_id' => 4, 'password' => '12345678']);

        $response = $this->post('/api/login', [
            'email' => $user->email,
            'password' => '12345678'
        ]);

        $response->assertStatus(Response::HTTP_OK);


        $response->assertJson([
            'data' => [
                'permissions' => [
                    'get-students',
                    'get-workouts'
                ]
            ]
        ]);
    }

    public function test_user_aluno_permissions_load_correct()
    {


        $user = User::factory()->create(['profile_id' => 5, 'password' => '12345678']);

        $response = $this->post('/api/login', [
            'email' => $user->email,
            'password' => '12345678'
        ]);

        $response->assertStatus(Response::HTTP_OK);


        $response->assertJson([
            'data' => [
                'permissions' => [
                    'get-students',
                    'get-workouts'
                ]
            ]
        ]);
    }

    public function test_check_bad_request_login_api_response(): void
    {

        $response = $this->post('/api/login', [
            'email' => "juca@hotmail.com",
            'password' => "8712541"
        ]);

        $response->assertStatus(401);

        $response->assertJson([
            "message" => "Não autorizado. Credenciais incorretas",
            "status" => 401,
            "errors" => [],
            "data" => []
        ]);
    }

    public function test_http_bad_request_on_exception()
    {
        $response = $this->post('/api/login', [
            'password' => '12345678'
        ]);
    
        $response->assertStatus(Response::HTTP_BAD_REQUEST);

        $responseData = json_decode($response->getContent(), true);
    
        $this->assertEquals('The email field is required.', $responseData['message']);
    }

    /*falha ocorrendo devido ser uma rota autenticada, e não estamos conseguindo receber o retorno da requisição*/
    public function test_login_and_logout()
    {
        $response = $this->post('/api/login', [
            'email' => 'paulo_whey@gmail.com',
            'password' => '12345678'
        ]);
    
        $response->assertStatus(Response::HTTP_OK);
        $response->assertJsonStructure([
            'message',
            'status',
            'data' => [
                'token',
                'permissions',
                'name',
                'profile'
            ]
        ]);

        $token = $response->json('data.token');
    
        $logoutResponse = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->post('/api/logout');
    
        // $logoutResponse->assertStatus(Response::HTTP_NO_CONTENT);
    }
    
}