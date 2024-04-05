<?php
namespace Database\Factories;


use Illuminate\Database\Eloquent\Factories\Factory;

class StudentFactory extends Factory
{

    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'email' => $this->faker->unique()->safeEmail,
            'date_birth' => $this->faker->date('Y-m-d'),
            'contact' => $this->faker->phoneNumber,
            'cpf' => $this->faker->unique()->regexify('^\d{3}\.\d{3}\.\d{3}-\d{2}$'),
            'cep' => $this->faker->postcode,
            'street' => $this->faker->streetName,
            'state' => $this->faker->stateAbbr,
            'neighborhood' => $this->faker->citySuffix,
            'city' => $this->faker->city,
            'number' => $this->faker->buildingNumber,
            'complement' => $this->faker->optional()->text(50)
        ];
    }
}
