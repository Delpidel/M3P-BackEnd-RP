<?php

namespace Tests\Feature;

use App\Models\MealPlan;
use App\Models\MealPlanSchedule;
use App\Models\Student;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class MealsTest extends TestCase
{
    public function test_can_list_all_meals()
    {
        $this->seed(DatabaseSeeder::class);
        MealPlanSchedule::factory()->count(10)->create();

        $response = $this->get('/api/meals');
        $response->assertStatus(200)->assertJsonStructure([
            '*' => [
                'id',
                'meal_plan_id',
                'title',
                'description',
                'hour',
                'day',
                'created_at',
                'updated_at'
            ]
        ]);

    }

    public function test_can_create_meal_plans_schedule()
    {
        $this->seed(DatabaseSeeder::class);

        $student = Student::factory()->create();
        $meal_plan = MealPlan::factory()->create(['student_id' => $student->id]);

        $response = $this->post('/api/cad_meal', [
            'meal_plan_id' => $meal_plan->id,
            'hour' => '08:00',
            'title' => 'cafe da manha',
            'description' => 'pao com ovos',
            'day' => 'SEGUNDA',
        ]);

        $response->assertStatus(201);

        $response->assertJson([
            'meal_plan_id' => true,
            'hour' => $response['hour'],
            'title' => $response['title'],
            'description' => $response['description'],
            'day' => $response['day']
        ]);

        // Test with empty data
        $response = $this->post('/api/cad_meal', []);
        $response->assertStatus(400);

        $response->assertJson([
            "message" => "The meal plan id field is required. (and 3 more errors)",
            "status" => 400,
            "errors" => [],
            "data" => []
        ]);

        // Test with invalid day
        $response = $this->post('/api/cad_meal', [
            'meal_plan_id' => $meal_plan->id,
            'hour' => '08:00',
            'title' => 'cafe da manha',
            'description' => 'pao com ovos',
            'day' => 'sabado',
        ]);
        $response->assertStatus(400);

        $response->assertJson([
            "message" => "The selected day is invalid.",
            "status" => 400,
            "errors" => [],
            "data" => []
        ]);

        // Test with missing required fields
        $response = $this->post('/api/cad_meal', [
            // Missing 'meal_plan_id'
            'hour' => '08:00',
            'title' => 'cafe da manha',
            'description' => 'pao com ovos',
            'day' => 'SEGUNDA',
        ]);
        $response->assertStatus(400);

        $response->assertJson([
            "message" => "The meal plan id field is required.",
            "status" => 400,
            "errors" => [],
            "data" => []
        ]);
    }

    public function test_can_edit_one_meal(): void
    {
        $this->seed(DatabaseSeeder::class);

        $meal = MealPlanSchedule::factory()->create();

        $body = ['hour' => '9:00', 'description' => 'torradas'];
        $response = $this->put("/api/update_meal/$meal->id", $body);

        $this->assertDatabaseHas('meal_plans_schedule', [
            'id' => $meal->id,
            'hour' => $body['hour'],
            'description' => $body['description']
        ]);

        $response->assertStatus(200);
        $response->assertJson([
            'id' => true,
            'meal_plan_id' => true,
            'title' => true,
            'description' => $body['description'],
            'hour' => $body['hour'],
            'day' => true
        ]);
    }
}
