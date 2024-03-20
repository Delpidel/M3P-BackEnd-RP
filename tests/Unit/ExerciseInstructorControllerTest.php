<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Interfaces\ExerciseInstructorRepositoryInterface;
use Illuminate\Http\Response;

class ExerciseInstructorControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->mock(ExerciseInstructorRepositoryInterface::class, function ($mock) {
            $mock->shouldReceive('getUserExercises')->andReturn((object)[
                'current_page' => 1,
                'data' => [
                    ['id' => 1, 'description' => 'teste1'],
                    ['id' => 2, 'description' => 'teste2'],
                    ['id' => 3, 'description' => 'teste3'],
                    ['id' => 4, 'description' => 'teste4']
                ],
                'first_page_url' => 'http://localhost:8000/api/exercises?page=1',
                'from' => 1,
                'last_page' => 1,
                'last_page_url' => 'http://localhost:8000/api/exercises?page=1',
                'links' => [
                    ['url' => null, 'label' => '&laquo; Previous', 'active' => false],
                    ['url' => 'http://localhost:8000/api/exercises?page=1', 'label' => '1', 'active' => true],
                    ['url' => null, 'label' => 'Next &raquo;', 'active' => false]
                ],
                'next_page_url' => null,
                'path' => 'http://localhost:8000/api/exercises',
                'per_page' => 10,
                'prev_page_url' => null,
                'to' => 4,
                'total' => 4
            ]);
        });
    }

    /** @test */
    public function test_authenticated_instructor_can_access_exercise_list()
    {
        $user = User::create([
            'name' => 'Paulo Instrutor',
            'email' => 'paulo_whey@gmail.com',
            'password' => Hash::make('12345678'),
            'profile_id' => 3,
        ]);

        $loginResponse = $this->postJson('/api/login', [
            'email' => 'paulo_whey@gmail.com',
            'password' => '12345678',
        ]);

        $token = $loginResponse->json('data.token');

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->get('/api/exercises');

        $response->assertStatus(200);
        $response->assertJson([
            'current_page' => 1,
            'data' => [
                ['id' => 1, 'description' => 'teste1'],
                ['id' => 2, 'description' => 'teste2'],
                ['id' => 3, 'description' => 'teste3'],
                ['id' => 4, 'description' => 'teste4']
            ],
            'first_page_url' => 'http://localhost:8000/api/exercises?page=1',
            'from' => 1,
            'last_page' => 1,
            'last_page_url' => 'http://localhost:8000/api/exercises?page=1',
            'links' => true,
            'next_page_url' => null,
            'path' => 'http://localhost:8000/api/exercises',
            'per_page' => 10,
            'prev_page_url' => null,
            'to' => 4,
            'total' => 4
        ]);
    }

    /** @test */
    public function unauthenticated_request_returns_route_login_not_defined_error()
    {
        $response = $this->get('/api/exercises');

        $response->assertStatus(500);
        $response->assertSee('Route [login] not defined.');
    }


}
