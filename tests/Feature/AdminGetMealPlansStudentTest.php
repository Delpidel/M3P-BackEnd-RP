<?php

namespace Tests\Feature;

use App\Models\MealPlans;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AdminGetMealPlansStudentTest extends TestCase
{

    public function test_student_can_get_meal_plans()
    {
        $user = User::factory()->create(['profile_id' => 1]);
        $token = $user->createToken('@academia', ['get-meal-plans'])->plainTextToken;
        $response = $this->withHeader('Authorization', 'Bearer ' . $token)->get('/api/students/meal_plans');
        $response->assertStatus(200)->assertJsonStructure([
            '*' => [
                'description',
                'created_at',
                'updated_at',
                'student_id'
            ]
        ]);
    }


}
