<?php

namespace Database\Factories;

use App\Models\MealPlan;
use App\Models\Student;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\MealPlanSchedule>
 */
class MealPlanScheduleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $student = Student::factory()->create();
        $meal_plan = MealPlan::factory()->create(['student_id' => $student->id]);

        return [
            'meal_plan_id' => $meal_plan->id,
            'student_id' => $student->id,
            'hour' => '08:00',
            'title' => 'cafe da manha',
            'description' => 'pao com ovos',
            'day' => 'SEGUNDA'
        ];
    }
}
