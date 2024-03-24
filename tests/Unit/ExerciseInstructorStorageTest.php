<?php

namespace Tests\Feature;

use App\Models\Exercise;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ExerciseInstructorStorageTest extends TestCase
{
    use RefreshDatabase;

    public function test_instructor_can_create_exercise()
    {

        $user = User::factory()->create(['profile_id' => 3]);
        $token = $user->createToken('12345678', ['create-exercises'])->plainTextToken;

        $exercise = [
            'description' => 'Supino Canadense',
        ];

        $response = $this->withHeader('Authorization', 'Bearer ' . $token)
            ->postJson('/api/exercises', $exercise);

        $response->assertStatus(201)
            ->assertJsonStructure([
                'description',
                'id',
            ]);

        $this->assertDatabaseHas('exercises', $exercise);

    }

    public function test_other_users_can_not_create_exercise()
    {

        $this->withoutExceptionHandling();

        $user = User::factory()->create(['profile_id' => 2]);
        $token = $user->createToken('12345678', [''])->plainTextToken;

        $exercise = [
            'description' => 'Supino Canadense',
        ];

        //Capturar o erro de ausência da habilidade
        $this->expectException(\Laravel\Sanctum\Exceptions\MissingAbilityException::class);

        $this->withHeader('Authorization', 'Bearer ' . $token)
            ->postJson('/api/exercises', $exercise);

    }

    public function test_exercise_already_exists_for_this_user()
    {

        $user = User::factory()->create(['profile_id' => 3]);
        $token = $user->createToken('12345678', ['create-exercises'])->plainTextToken;

        $exercise = [
            'description' => "Supino Canadense",
            'user_id' => $user->id
        ];

        Exercise::create($exercise);

        // Tentar criar o mesmo exercício novamente
        $response = $this->withHeader('Authorization', 'Bearer ' . $token)
            ->postJson('/api/exercises', $exercise);

        $response->assertStatus(409)
            ->assertJson([
                'message' => 'O exercício já existe para este usuário.',
            ]);

        $this->assertEquals(1, Exercise::count());

    }
}
