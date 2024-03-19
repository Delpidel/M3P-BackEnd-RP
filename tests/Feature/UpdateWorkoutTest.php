<?php

namespace Tests\Feature;

use App\Http\Requests\UpdateWorkoutRequest;
use App\Http\Services\Workout\UpdateOneWorkoutService;
use App\Models\Exercise;
use App\Models\Student;
use App\Models\User;
use App\Models\Workout;
use GuzzleHttp\Psr7\Request;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Validator;
use Tests\TestCase;

class UpdateWorkoutTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Testa a atualização de um treino (workout).
     *
     * @return void
     */
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
        $newDay = 'SEGUNDA';

        $response = $this->updateWorkout($workout->id, $user, [
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

    /**
     * Faz uma requisição PUT para atualizar um treino.
     *
     * @param int $workoutId
     * @param User $user
     * @param array $data
     * @return \Illuminate\Testing\TestResponse
     */
    private function updateWorkout(int $workoutId, User $user, array $data)
    {
        return $this->actingAs($user)
            ->put("/api/workouts/{$workoutId}", $data);
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
        $this->assertEquals(['O dia da semana deve ser um dos seguintes: SEGUNDA, TERÇA, QUARTA, QUINTA, SEXTA, SÁBADO, DOMINGO'], $validator->errors()->all());
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
}
