<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

class StudentFactory extends Factory
{

    public function definition(): array
    {
        return [
            'name' => $this->faker->name,
            'email' => $this->faker->unique()->safeEmail,
            'date_birth' => $this->faker->date(),
            'contact' => $this->faker->phoneNumber,
            'cpf' => $this->faker->unique()->numerify('###########'),
            'cep' => $this->faker->numerify('#####-###'),
            'city' => $this->faker->city,
            'neighborhood' => $this->faker->word,
            'number' => $this->faker->buildingNumber,
            'street' => $this->faker->streetName,
            'state' => $this->faker->stateAbbr,
            'user_id' => $this->faker->numberBetween(1, 10),
        ];
    }
}
