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
            'date_birth' => $this->faker->date(),
            'contact' => $this->faker->phoneNumber,
            'cpf' => function () {
                $cpf = $this->faker->numerify('###.###.###-##');
                return $cpf;
            },
            'city' => $this->faker->city,
            'neighborhood' => $this->faker->citySuffix,
            'number' => $this->faker->buildingNumber,
            'street' => $this->faker->streetName,
            'state' => $this->faker->stateAbbr,
            'cep' => $this->faker->postcode,
            'file_id' => null,
            'complement' => $this->faker->secondaryAddress,
        ];
    }
}
