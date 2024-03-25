<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class StudentWorkoutTest extends TestCase
{
    use DatabaseTransactions;
    
    public function testWorkoutsByStudent(): void
    {        
        $studentId = 6;    
        
        $user = User::factory()->create(['id' => $studentId]);    
        
        $this->actingAs($user);    
        
        $response = $this->get("/api/students/{$studentId}/workouts");      
        
        $response->assertStatus(200);
    }    

    public function testWorkoutsStudent(): void
    {        
        
        $studentId = 6; 
      
        $user = User::factory()->create(['id' => $studentId]);         
       
        $this->actingAs($user);    

        $response = $this->get("/api/students/{$studentId}/workouts");  

        $response->assertStatus(200);

        // Verificamos que la respuesta contenga los datos esperados
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
}