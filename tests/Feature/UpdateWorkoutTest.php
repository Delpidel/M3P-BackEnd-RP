<?php

namespace Tests\Feature;

use App\Http\Requests\UpdateWorkoutRequest;
use App\Models\Exercise;
use App\Models\Student;
use App\Models\User;
use App\Models\Workout;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Validator;
use Tests\TestCase;

class UpdateWorkoutTest extends TestCase
{
    use RefreshDatabase;

    public function test_catch_exception(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->put('/api/workouts/1', [
            'repetitions' => 10,
            'weight' => 76.23,
        ]);

        $responseData = $response->json();

        $response->assertStatus(404);

        $this->assertEquals('workout não encontrado', $responseData['message']);

        if (array_key_exists('status', $responseData)) {
            $this->assertEquals(404, $responseData['status']);
        } else {
            $this->fail('A chave "code" não está definida no array de resposta');
        }
    }

    public function test_can_update_workout(): void
    {
        $user = User::factory()->create();
        $student = Student::factory()->create(['user_id' => $user->id]);
        $exercise = Exercise::factory()->create();

        $workout = Workout::factory()->create([
            'student_id' => $student->id,
            'exercise_id' => $exercise->id,
            'user_id' => $user->id
        ]);

        $newRepetitions = 12;
        $newWeight = 11.5;
        $newDay = 'QUARTA';

        $response = $this->actingAs($user)
            ->put("/api/workouts/{$workout->id}", [
                'repetitions' => $newRepetitions,
                'weight' => $newWeight,
                'day' => $newDay,
            ]);

        $response->assertStatus(200)
            ->assertJson([
                'id' => $workout->id,
                'repetitions' => $newRepetitions,
                'weight' => $newWeight,
                'day' => $newDay,
            ]);
    }

    public function test_repetitions_must_be_an_integer(): void
    {
        $request = new UpdateWorkoutRequest();
        $validator = Validator::make(['repetitions' => 'string'], $request->rules(), $request->messages());

        $this->assertTrue($validator->fails());
        $this->assertEquals(['O número de repetições deve ser um número inteiro'], $validator->errors()->all());
    }

    public function test_weight_must_be_numeric(): void
    {
        $request = new UpdateWorkoutRequest();
        $validator = Validator::make(['weight' => 'string'], $request->rules(), $request->messages());

        $this->assertTrue($validator->fails());
        $this->assertEquals(['O peso deve ser um número decimal'], $validator->errors()->all());
    }

    public function test_break_time_must_be_an_integer(): void
    {
        $request = new UpdateWorkoutRequest();
        $validator = Validator::make(['break_time' => 'string'], $request->rules(), $request->messages());

        $this->assertTrue($validator->fails());
        $this->assertEquals(['O tempo de pausa entre as séries deve ser um número inteiro'], $validator->errors()->all());
    }

    public function test_day_must_be_valid(): void
    {
        $request = new UpdateWorkoutRequest();
        $validator = Validator::make(['day' => 'invalid_day'], $request->rules(), $request->messages());

        $this->assertTrue($validator->fails());
        $this->assertEquals(['O dia da semana deve ser um dos seguintes: SEGUNDA, TERCA, QUARTA, QUINTA, SEXTA, SABADO, DOMINGO'], $validator->errors()->all());
    }

    public function test_observations_must_be_a_string(): void
    {
        $request = new UpdateWorkoutRequest();
        $validator = Validator::make(['observations' => 123], $request->rules(), $request->messages());

        $this->assertTrue($validator->fails());
        $this->assertEquals(['As observações devem ser uma string'], $validator->errors()->all());
    }

    public function test_time_must_be_an_integer(): void
    {
        $request = new UpdateWorkoutRequest();
        $validator = Validator::make(['time' => 'string'], $request->rules(), $request->messages());

        $this->assertTrue($validator->fails());
        $this->assertEquals(['O tempo deve ser um número inteiro'], $validator->errors()->all());
    }

    public function test_exercise_id_must_exist_in_exercises_table(): void
{
    $request = new UpdateWorkoutRequest();
    $validator = Validator::make(['exercise_id' => 'string'], $request->rules(), $request->messages());

    $this->assertTrue($validator->fails());
    $this->assertEquals(['O ID do exercício deve ser um número inteiro'], $validator->errors()->all());
}

public function test_exercise_id_must_be_an_integer(): void
{
    $request = new UpdateWorkoutRequest();
    $validator = Validator::make(['exercise_id' => 999], $request->rules(), $request->messages());

    $this->assertTrue($validator->fails());
    $this->assertEquals(['O ID do exercício fornecido não existe'], $validator->errors()->all());
}

}
