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
    public function test_student_can_get_meal_plans_schedule(): void
    {
        $user = User::factory()->create(['profile_id' => 1]);
        $mealPlan = MealPlans::create(['description' => 'emagrecimento', 'student_id' => $user->id]);
        $mealPlanId = $mealPlan->id;
        $token = $user->createToken('@academia', ['get-meal-plans'])->plainTextToken;
        $response = $this->withHeader('Authorization', 'Bearer ' . $token)->get('/api/students/meal_plans/' . $mealPlanId); // Utilizar o ID do meal plan na requisição
        $response->assertStatus(200)->assertJsonStructure([
            'student_id',
            'student_name',
            'meal_plans' => [
                'SEGUNDA' => [],
                'TERÇA' => [],
                'QUARTA' => [],
                'QUINTA' => [],
                'SEXTA' => [],
                'SÁBADO' => [],
                'DOMINGO' => [],
            ],
        ]);
    }

    public function test_can_not_view_meal_plans_if_the_user_is_not_logged ()
    {
        $user = User::factory()->create(['profile_id' => 1]);
        $token = '';
        $response = $this->withHeader('Authorization', 'Bearer ' . $token)->get('/api/students/meal_plans');
        $response->assertStatus(500);
    }
    public function test_others_user_can_not_view_meal_plan_schedule_from_other_student ()
    {
        $user1 = User::factory()->create(['profile_id' => 1]);
        $user2 = User::factory()->create(['profile_id' => 1]);
        $mealPlan = MealPlans::create(['description' => 'emagrecimento', 'student_id' => $user1->id]);
        $mealPlanId = $mealPlan->id;
        $token = $user2->createToken('@academia', ['get-meal-plans'])->plainTextToken;
        $response = $this->withHeader('Authorization', 'Bearer ' . $token)->get('/api/students/meal_plans/' . $mealPlanId);
        $response->assertStatus(404);


    }


}
