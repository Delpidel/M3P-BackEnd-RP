<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Student>
 */
class StudentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name,
            'email' => $this->faker->unique()->safeEmail,
            'cpf' => $this->faker->numerify('###.###.###-##'),
            'date_birth' => $this->faker->date($format = 'Y-m-d', $max = 'now'),
            'contact' => $this->faker->phoneNumber,
            'cep' => $this->faker->postcode,
            'street' => $this->faker->streetName,
            'state' => $this->faker->stateAbbr,
            'neighborhood' => $this->faker->word,
            'city' => $this->faker->city,
            'number' => $this->faker->buildingNumber,
        ];
    }
}
