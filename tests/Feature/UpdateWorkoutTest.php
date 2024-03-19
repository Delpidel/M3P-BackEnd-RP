<?php

namespace Tests\Feature;

use App\Models\Exercise;
use App\Models\Profile;
use App\Models\Student;
use App\Models\User;
use App\Models\Workout;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Log;
use Tests\TestCase;

class UpdateWorkoutTest extends TestCase
{
    public function test_can_edit_one_workout(): void
    {
        $user = User::factory()->create();
        Log::info("User criado", ['user_id' => $user->id]);

        $student = Student::factory()->create(['user_id' => $user->id]);
        Log::info("Estudante criado", ['student_id' => $student->id]);

        $exercise = Exercise::factory()->create();
        Log::info("Exercise criado", ['exercise_id' => $exercise->id]);

        $workout = Workout::factory()->create([
            'student_id' => $student->id,
            'exercise_id' => $exercise->id,
            'user_id' => $user->id
        ]);

        Log::info("Workout criado", ['workout' => $workout]);

        $newRepetitions = 3;
        $newWeight = 15.0;

        $body = [
            'repetitions' => $newRepetitions,
            'weight' => $newWeight,
            'break_time' => 30,
            'day' => 'SEGUNDA',
            'observations' => '',
            'time' => 60
        ];

        Log::info("Valores atualizados do workout", [
            'repetitions' => $workout->repetitions,
            'weight' => $workout->weight
        ]);

        // Faça a requisição PUT com os novos valores
        $response = $this->actingAs($user)->put("/api/students/{$student->id}/workouts", $body);

        Log::info("response", ['response' => $response]);

        $this->assertDatabaseHas('workouts', [
            'id' => $workout->id,
            'repetitions' => $newRepetitions, // Verifique se as novas repetições estão corretas
            'weight' => $newWeight // Verifique se o novo peso está correto
        ]);

        // Verifique se a resposta da requisição está correta
        $response->assertStatus(200);

        $response->assertJson([
            'id' => true,
            'exercise_id' => true,
            'repetitions' => $newRepetitions, // Verifique se as novas repetições estão corretas
            'weight' => $newWeight, // Verifique se o novo peso está correto
            'break_time' => $body['break_time'],
            'day' => $body['day'],
            'time' => $body['time']
        ]);
    }
}
