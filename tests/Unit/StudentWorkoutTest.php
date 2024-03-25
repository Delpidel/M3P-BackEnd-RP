<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Http\Controllers\WorkoutController;
use App\Models\User;

class StudentWorkoutTest extends TestCase
{
    public function testWorkoutsByStudent(): void
    {        
        $studentId = 6;    
        
        $user = User::factory()->create(['id' => $studentId]);    
        
        $this->actingAs($user);    
        
        $response = $this->get("/api/students/{$studentId}/workouts");      
        
        $response->assertStatus(200);
    }    
    
}
