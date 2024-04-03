<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class StudentFactory extends Factory
{

    public function definition(): array
    {
        return [
            'name' => $this->faker->name,
            'email' => $this->faker->unique()->safeEmail,
            'cpf' => $this->faker->numerify('###########'),
            'date_birth' => $this->faker->date,
            'contact' => $this->faker->phoneNumber,
            'cep' => $this->faker->numerify('########'),
            'street' => $this->faker->streetName,
            'state' => $this->faker->stateAbbr,
            'neighborhood' => $this->faker->city,
            'city' => $this->faker->city,
            'number' => $this->faker->randomNumber(3),
            'complement' => 'Apartamento ' . $this->faker->randomNumber(2)
        ];
    }
}
