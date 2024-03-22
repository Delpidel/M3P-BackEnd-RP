<?php

namespace Tests\Feature;

use App\Models\MealPlanSchedule;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class MealPlanScheduleControllerTest extends TestCase
{
    use DatabaseTransactions;

    // public function test_store_method_creates_meal_plan_schedule()
    // {
    //     $data = [
    //         'meal_plan_id' => 1,
    //         'hour' => '08:00',
    //         'title' => 'Breakfast',
    //         'description' => 'Healthy breakfast',
    //         'day' => 'SEGUNDA',
    //     ];

    //     $response = $this->postJson('/meal-plans-schedule', $data);

    //     $response->assertStatus(201)
    //         ->assertJson($data);

    //     $this->assertDatabaseHas('meal_plans_schedules', $data);
    // }

    public function test_index_method_returns_all_meal_plan_schedules()
    {
        $mealPlanSchedules = MealPlanSchedule::factory()->count(3)->create();

        $response = $this->getJson('/meal-plans-schedule');

        $response->assertStatus(200)
            ->assertJson($mealPlanSchedules->toArray());
    }


    // public function test_destroy_method_deletes_meal_plan_schedule()
    // {
    //     $mealPlanSchedule = MealPlanSchedule::factory()->create();

    //     $response = $this->deleteJson("/meal-plans-schedule/{$mealPlanSchedule->id}");

    //     $response->assertStatus(204);

    //     $this->assertDatabaseMissing('meal_plans_schedules', ['id' => $mealPlanSchedule->id]);
    // }

    // public function test_update_method_updates_meal_plan_schedule()
    // {
    //     $mealPlanSchedule = MealPlanSchedule::factory()->create();

    //     $data = [
    //         'hour' => '09:00',
    //         'title' => 'Morning Snack',
    //         'description' => 'Healthy snack',
    //         'day' => 'TERCA',
    //     ];

    //     $response = $this->putJson("/meal-plans-schedule/{$mealPlanSchedule->id}", $data);

    //     $response->assertStatus(200)
    //         ->assertJson($data);

    //     $this->assertDatabaseHas('meal_plans_schedules', $data);
    // }
}
