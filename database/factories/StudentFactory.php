<?php

namespace Database\Factories;

use App\Models\Student;
use Illuminate\Database\Eloquent\Factories\Factory;

class StudentFactory extends Factory
{
    protected $model = Student::class;

    public function definition(): array
    {
        return [
            'name' => fake()->name,
            'email' => fake()->unique()->safeEmail,
            'date_birth' => fake()->date('Y-m-d'),
            'contact' => fake()->phoneNumber,
            'cpf' => fake()->unique()->regexify('^\d{3}\.\d{3}\.\d{3}-\d{2}$'),
            'cep' => fake()->postcode,
            'street' => fake()->streetName,
            'state' => fake()->stateAbbr,
            'neighborhood' => fake()->citySuffix,
            'city' => fake()->city,
            'number' => fake()->buildingNumber,
        ];
    }
}