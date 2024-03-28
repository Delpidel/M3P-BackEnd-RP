<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

class StudentFactory extends Factory
{

    public function definition(): array
    {
        return [
            'name' => $this->faker->name
        ];
    }
}
