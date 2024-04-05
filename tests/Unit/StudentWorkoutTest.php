<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class StudentWorkoutTest extends TestCase
{
    use DatabaseTransactions;

    public function test_workouts_by_student(): void
    {
        $studentId = 6;

        $user = User::factory()->create(['id' => $studentId]);

        $this->actingAs($user);

        $response = $this->get("/api/student/{$studentId}/workouts");

        $response->assertStatus(200);
    }


    public function test_workouts_by_student_format(): void
    {

        $studentId = 6;

        $user = User::factory()->create(['id' => $studentId]);

        $this->actingAs($user);

        $response = $this->get("/api/student/{$studentId}/workouts");

        $response->assertStatus(200);

        $response->assertJsonStructure([
            'student_id',
            'name',
            'workouts' => [
                '*' => [
                    '*' => [
                        'description',
                        'repetitions',
                        'weight',
                        'break_time',
                        'observations',
                        'time',
                        'created_at'
                    ]
                ]
            ]
        ]);
    }

    public function test_student_can_list_their_own_workouts()
    {
        $student = User::factory()->create(['profile_id' => 5]);
        $token = $student->createToken('@academia', ['get-workout'])->plainTextToken;

        $response = $this->withHeader('Authorization', 'Bearer ' . $token)->get('/api/student/' . $student->id . '/workouts');
        $response->assertStatus(200);
    }

    public function test_student_can_not_get_workouts_from_another_student()
    {
        $student = User::factory()->create(['profile_id' => 5]);
        $token = $student->createToken('@academia', [''])->plainTextToken;

        $response = $this->withHeader('Authorization', 'Bearer ' . $token)->get('/api/student/' . $student->id . '/workouts');
        $response->assertStatus(403);
    }

    public function test_no_workouts_for_unauthenticated_user()
    {

        $this->assertGuest();

        $studentId = 6;
        $response = $this->get("/api/student/{$studentId}/workouts");

        $response->assertStatus(500);
    }
}
