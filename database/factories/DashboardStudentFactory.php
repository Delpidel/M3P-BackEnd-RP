<?php

namespace Database\Factories;

use App\Models\Student;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class DashboardStudentFactory extends Factory
{
    protected $model = Student::class;

    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'email' => $this->faker->safeEmail,
            'date_birth' => $this->faker->date(),
            'contact' => $this->faker->phoneNumber,
            'cpf' => $this->faker->numerify('###.###.###-##'),
            'city' => $this->faker->city,
            'neighborhood' => $this->faker->word,
            'number' => $this->faker->buildingNumber,
            'street' => $this->faker->streetName,
            'state' => $this->faker->stateAbbr,
            'cep' => $this->faker->postcode,
            'file_id' => null,
            'complement' => $this->faker->secondaryAddress,
            'user_id' => function () {
                return User::factory()->create()->id;
            },
        ];
    }
}
