<?php

namespace Database\Factories;

use App\Models\MealPlanSchedule;
use Illuminate\Database\Eloquent\Factories\Factory;

class MealPlanScheduleFactory extends Factory
{
    protected $model = MealPlanSchedule::class;

    public function definition()
    {
        return [
            'meal_plan_id' => 1,
            'hour' => $this->faker->time('H:i'),
            'title' => $this->faker->word,
            'description' => $this->faker->sentence,
            'day' => $this->faker->randomElement(['SEGUNDA', 'TERCA', 'QUARTA', 'QUINTA', 'SEXTA', 'SABADO', 'DOMINGO']),
        ];
    }
}
