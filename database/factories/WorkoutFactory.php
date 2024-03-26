<?php

namespace Database\Factories;

use App\Models\Student;
use App\Models\User;
use App\Models\Workout;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class WorkoutFactory extends Factory
{
    protected $model = Workout::class;

    public function definition(): array
    {
        $user = User::factory()->create();
        return [
            'user_id' => $user->id,
            'repetitions' => $this->faker->numberBetween(1, 12),
            'weight' => $this->faker->randomFloat(2, 1, 100),
            'break_time' => $this->faker->numberBetween(30, 600),
            'day' => $this->faker->randomElement(['SEGUNDA', 'TERÇA', 'QUARTA', 'QUINTA', 'SEXTA', 'SÁBADO', 'DOMINGO']),
            'observations' => $this->faker->text(),
            'time' => $this->faker->numberBetween(60, 3600)
        ];
    }
}
