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
=======
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Student>
 */
class StudentFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Student::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => 'João da Silva',
            'email' => 'joao@example.com',
            'cpf' => '024.892.560-26',
            'date_birth' => '1945-01-24',
            'contact' => '980579171',
            'cep' => '96810174',
            'street' => 'Rua vinte e oito de setembro',
            'state' => 'RS',
            'neighborhood' => 'Centro',
            'city' => 'Santa cruz do sul',
            'number' => '642'
        ];
    }
}
