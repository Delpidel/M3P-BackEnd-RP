<?php

namespace Tests\Feature;

use App\Http\Requests\StoreWorkoutRequest;
use App\Models\Exercise;
use App\Models\Student;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CreateWorkoutTest extends TestCase
{
    use RefreshDatabase;

    public function test_catch_exception(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->post('/api/workouts', [
            'repetitions' => 10,
            'weight' => 76.23,
        ]);

        $responseData = $response->json();

        $response->assertStatus(404);
        $this->assertEquals('workout não encontrado', $responseData['message']);

        if (array_key_exists('status', $responseData)) {
            $this->assertEquals(404, $responseData['status']);
        } else {
            $this->fail('A chave "status" não está definida no array de resposta');
        }
    }
    //Ainda em desenvolvimento
    public function test_create_workout(): void
    {
        $user = User::factory()->create();
        $student = Student::factory()->create(['user_id' => $user->id]);
        $exercise = Exercise::factory()->create();

        $data = [
            'student_id' => $student->id,
            'exercise_id' => $exercise->id,
            'repetitions' => 10,
            'weight' => 10,
            'break_time' => 10,
            'day' => 'SEGUNDA',
            'observations' => 'Observações',
            'time' => 60,
        ];

        // Valida os dados da requisição usando regras e mensagens do StoreWorkoutRequest
        $request = new StoreWorkoutRequest();
        $validator = $this->app['validator']->make($data, $request->rules(), $request->messages());

        $this->assertFalse($validator->fails(), 'Os dados da requisição não passaram na validação.');

        // Se os dados passarem na validação, continuar com a criação do treino
        $response = $this->actingAs($user)->post('/api/workouts', $data);

        $response->assertStatus(201);
        $response->assertJson([
            // Verifica se os dados retornados correspondem aos dados enviados
            'student_id' => $data['student_id'],
            'exercise_id' => $data['exercise_id'],
            'repetitions' => $data['repetitions'],
            'weight' => $data['weight'],
            'break_time' => $data['break_time'],
            'day' => $data['day'],
            'observations' => $data['observations'],
            'time' => $data['time'],
        ]);

        // Verifica se o treino foi realmente criado no banco de dados
        $this->assertDatabaseHas('workouts', $data);
    }

    //Testes abaixo verificam valores individuais
    public function test_student_id_required(): void
    {
        $response = $this->actingAs(User::factory()->create())->postJson('/api/workouts', [
            'exercise_id' => Exercise::factory()->create()->id,
            'repetitions' => 10,
            'weight' => 76.23,
            'break_time' => 5,
            'day' => 'SEGUNDA',
            'time' => 60,
        ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['student_id']);
    }

    public function test_exercise_id_required(): void
    {
        $response = $this->actingAs(User::factory()->create())->postJson('/api/workouts', [
            'student_id' => Student::factory()->create()->id,
            'repetitions' => 10,
            'weight' => 76.23,
            'break_time' => 5,
            'day' => 'SEGUNDA',
            'time' => 60,
        ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['exercise_id']);
    }

    public function test_repetitions_required(): void
    {
        $response = $this->actingAs(User::factory()->create())->postJson('/api/workouts', [
            'student_id' => Student::factory()->create()->id,
            'exercise_id' => Exercise::factory()->create()->id,
            'weight' => 76.23,
            'break_time' => 5,
            'day' => 'SEGUNDA',
            'time' => 60,
        ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['repetitions']);
    }

    public function test_weight_required(): void
    {
        $response = $this->actingAs(User::factory()->create())->postJson('/api/workouts', [
            'student_id' => Student::factory()->create()->id,
            'exercise_id' => Exercise::factory()->create()->id,
            'repetitions' => 10,
            'break_time' => 5,
            'day' => 'SEGUNDA',
            'time' => 60,
        ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['weight']);
    }

    public function test_break_time_required(): void
    {
        $response = $this->actingAs(User::factory()->create())->postJson('/api/workouts', [
            'student_id' => Student::factory()->create()->id,
            'exercise_id' => Exercise::factory()->create()->id,
            'repetitions' => 10,
            'weight' => 76.23,
            'day' => 'SEGUNDA',
            'time' => 60,
        ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['break_time']);
    }

    public function test_day_required(): void
    {
        $response = $this->actingAs(User::factory()->create())->postJson('/api/workouts', [
            'student_id' => Student::factory()->create()->id,
            'exercise_id' => Exercise::factory()->create()->id,
            'repetitions' => 10,
            'weight' => 76.23,
            'break_time' => 5,
            'time' => 60,
        ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['day']);
    }

    public function test_time_required(): void
    {
        $response = $this->actingAs(User::factory()->create())->postJson('/api/workouts', [
            'student_id' => Student::factory()->create()->id,
            'exercise_id' => Exercise::factory()->create()->id,
            'repetitions' => 10,
            'weight' => 76.23,
            'break_time' => 5,
            'day' => 'SEGUNDA',
        ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['time']);
    }
}
