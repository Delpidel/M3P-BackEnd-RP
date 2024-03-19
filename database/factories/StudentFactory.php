<?php

namespace Database\Factories;

use App\Models\Student;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class StudentFactory extends Factory
{
    protected $model = Student::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->name,
            // 'email' => $this->faker->unique()->email,
            // 'date_birth' => $this->faker->dateTimeThisCentury()->format('Y-m-d'),
            // 'cpf' => $this->faker->numerify('###.###.###-##'),
            // 'contact' => $this->faker->phoneNumber(),
            // 'cep' => $this->faker->postcode,
            // 'street' => $this->faker->streetName,
            // 'state' => $this->faker->state,
            // 'neighborhood' => $this->faker->citySuffix,
            // 'city' => $this->faker->city,
            // 'number' => $this->faker->buildingNumber
        ];
    }
}
