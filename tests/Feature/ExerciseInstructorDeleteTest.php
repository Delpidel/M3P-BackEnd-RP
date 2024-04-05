<?php

namespace Tests\Feature;

use App\Models\Exercise;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ExerciseInstructorDeleteTest extends TestCase
{

    use RefreshDatabase;

    public function test_instructor_can_delete_exercise()
    {
        $user = User::factory()->create(['profile_id' => 3]);
        $token = $user->createToken('12345678', ['delete-exercises'])->plainTextToken;

        $exercise = Exercise::factory()->create();

        $response = $this->withHeader('Authorization', 'Bearer ' . $token)
            ->delete('/api/exercises/' . $exercise->id);

        $response->assertStatus(204);
    }

    public function test_other_users_can_not_delete_exercise()
    {
        $this->withoutExceptionHandling();

        $user = User::factory()->create(['profile_id' => 2]);
        $token = $user->createToken('12345678', [''])->plainTextToken;

        $exercise = Exercise::factory()->create();

        //Capturar o erro de ausência da habilidade
        $this->expectException(\Laravel\Sanctum\Exceptions\MissingAbilityException::class);

        $this->withHeader('Authorization', 'Bearer ' . $token)
            ->delete('/api/exercises/' . $exercise->id);
    }

    public function test_exercise_not_found_in_database()
    {
        $user = User::factory()->create(['profile_id' => 3]);
        $token = $user->createToken('12345678', ['delete-exercises'])->plainTextToken;

        $exercise = Exercise::factory()->create();

        $response = $this->withHeader('Authorization', 'Bearer ' . $token)
            ->delete('/api/exercises/' . $exercise->id + 1);

        $response->assertStatus(404)->assertJson([
            "message" => "Exercício não encontrado no banco de dados.",
            "status" => 404,
            "errors" => [],
            "data" => []
        ]);
    }
}
