<?php

namespace Database\Factories;

use App\Models\Exercise;
use Illuminate\Database\Eloquent\Factories\Factory;

class DashboardExerciseFactory extends Factory
{
    protected $model = Exercise::class;

    public function definition()
    {
        return [
            'description' => $this->faker->sentence,
            // 'user_id' será atribuído durante a criação do teste
        ];
    }
}
