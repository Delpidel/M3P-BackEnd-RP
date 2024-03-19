<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Workout;

use Tests\TestCase;

class DeleteWorkoutTest extends TestCase
{
    /**
     * A basic feature test example.
     */

    public function test_user_can_delete_workout(){

        $workoutCreated = Workout::factory()->create();

        $user = User::factory()->create(['profile_id'=>1, 'password'=>'12345678']);
        $response = $this->actingAs($user)->delete("/api/workouts/$workoutCreated->id");

        $response->assertStatus(204);
       $this->assertDatabaseMissing('workouts',['id'=>$workoutCreated]);
    }
}
