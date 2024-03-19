<?php

namespace Database\Factories;

use App\Models\Exercise;
use App\Models\Student;
use Illuminate\Database\Eloquent\Factories\Factory;

class WorkoutFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {

        $student = Student::factory()->create();


        $exercise = Exercise::factory()->create();

        return [
            'student_id' => $student->id,
            'exercise_id' => $exercise->id,
            'repetitions' => $this->faker->randomNumber(),
            'weight' => $this->faker->randomFloat(2),
            'break_time' => $this->faker->randomNumber(),
            'day' => $this->faker->randomElement(['SEGUNDA', 'TERÇA', 'QUARTA', 'QUINTA', 'SEXTA', 'SÁBADO', 'DOMINGO']),
            'observations' => $this->faker->optional()->text(),
            'time' => $this->faker->randomNumber(),
        ];
    }
}
