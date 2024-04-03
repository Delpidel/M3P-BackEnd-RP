<?php

namespace Tests\Feature;

use App\Models\MealPlans;
use App\Models\Student;
use App\Models\User;
use App\Models\UserStudent;
use Tests\TestCase;

class AdminGetMealPlansStudentTest extends TestCase
{

    public function test_student_can_get_meal_plans()
    {
        $user = User::factory()->create(['profile_id' => 5]);
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

    public function test_student_can_get_meal_plans_schedule()
    {
        $user = User::factory()->create(['profile_id' => 5]);
        $student = Student::create([
            'name' => 'Douglas da Silva',
            'email' => 'joao@example.com',
            'cpf' => '024.892.560-26',
            'date_birth' => '1945-01-24',
            'contact' => '980579171',
            'cep' => '96810174',
            'street' => 'Rua vinte e oito de setembro',
            'state' => 'RS',
            'neighborhood' => 'Centro',
            'city' => 'Santa cruz do sul',
            'number' => '642',
        ]);
        UserStudent::create([
            'user_id' => $user->id,
            'student_id' => $student->id,
        ]);
        $studentId = UserStudent::where('user_id', $user->id)->value('student_id');
        $mealPlan = MealPlans::create(['description' => 'emagrecimento', 'student_id' => $studentId]);
        $mealPlanId = $mealPlan->id;
        $token = $user->createToken('@academia', ['get-meal-plans'])->plainTextToken;

        $response = $this->withHeader('Authorization', 'Bearer ' . $token)->get('/api/students/meal_plans/' . $mealPlanId);

        $response->assertStatus(200)->assertJsonStructure([
            'student_id',
            'student_name',
            'meal_plans' => [
                'SEGUNDA' => [],
                'TERCA' => [],
                'QUARTA' => [],
                'QUINTA' => [],
                'SEXTA' => [],
                'SABADO' => [],
                'DOMINGO' => [],
            ],
        ]);
    }

    public function test_can_not_view_meal_plans_if_the_user_is_not_logged()
    {
        $response = $this->withHeader('Authorization', 'Bearer ' . '')->get('/api/students/meal_plans');

        $response->assertStatus(500);
    }

    public function test_others_user_can_not_view_meal_plan_schedule_from_other_student()
    {
        $user1 = User::factory()->create(['profile_id' => 5]);
        $user2 = User::factory()->create(['profile_id' => 5]);
        $mealPlan = MealPlans::create(['description' => 'emagrecimento', 'student_id' => $user1->id]);
        $mealPlanId = $mealPlan->id;
        $token = $user2->createToken('@academia', ['get-meal-plans'])->plainTextToken;

        $response = $this->withHeader('Authorization', 'Bearer ' . $token)->get('/api/students/meal_plans/' . $mealPlanId);

        $response->assertStatus(404);
    }
}
