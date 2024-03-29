<?php

namespace Database\Factories;

use App\Models\Student;
use Illuminate\Database\Eloquent\Factories\Factory;

class StudentFactory extends Factory
{
    protected $model = Student::class;

    public function definition()
    {
        return [
            'photo' => $this->faker->image('public/storage/photos', 400, 300, null, false), // Gera um nome de arquivo aleatório
            'name' => $this->faker->name,
            'email' => $this->faker->unique()->safeEmail,
            'date_birth' => $this->faker->date('Y-m-d'),
            'contact' => $this->faker->phoneNumber,
            'cpf' => $this->faker->unique()->regexify('^\d{3}.\d{3}.\d{3}-\d{2}$'),
            'cep' => $this->faker->postcode,
            'street' => $this->faker->streetName,
            'state' => $this->faker->stateAbbr,
            'neighborhood' => $this->faker->citySuffix,
            'city' => $this->faker->city,
            'number' => $this->faker->buildingNumber,
            'complement' => $this->faker->optional()->text(50),
        ];
    }
}
