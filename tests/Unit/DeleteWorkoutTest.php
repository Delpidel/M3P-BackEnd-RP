<?php

namespace Tests\Feature;

use App\Models\Exercise;
use App\Models\Student;
use App\Models\User;
use App\Models\Workout;

use Tests\TestCase;

class DeleteWorkoutTest extends TestCase
{
    public function test_user_can_delete_workout()
    {
        $user = User::factory()->create(['profile_id' => 3, 'password' => '12345678']);
        $student = Student::factory()->create(['user_id' => $user->id]);
        $exercise = Exercise::factory()->create();

        $workoutCreated = Workout::factory()->create([
            'student_id' => $student->id,
            'exercise_id' => $exercise->id
        ]);


        $response = $this->actingAs($user)->delete("/api/workouts/$workoutCreated->id");

        $response->assertStatus(204);
        $this->assertDatabaseMissing('workouts', ['id' => $workoutCreated]);
    }

    public function test_user_can_not_delete_non_existing_workout()
    {
        $user = User::factory()->create(['profile_id' => 3, 'password' => '12345678']);
        $nonExistingWorkoutId = 9999;

        $response = $this->actingAs($user)->delete("/api/workouts/$nonExistingWorkoutId");

        $response->assertStatus(404);
    }
}
