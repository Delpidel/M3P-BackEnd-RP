<?php

namespace Database\Factories;

use App\Models\Avaliation;
use App\Models\Student;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class AvaliationFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Avaliation::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
            $backImage = UploadedFile::fake()->image('back.jpg');
            $frontImage = UploadedFile::fake()->image('front.jpg');
            $leftImage = UploadedFile::fake()->image('left.jpg');
            $rightImage = UploadedFile::fake()->image('right.jpg');

        $studentId = Student::factory()->create()->id;
            return [
                'student_id' => $studentId,
                'date' => $this->faker->date(),
                'weight' => $this->faker->randomFloat(2, 40, 100),
                'height' => $this->faker->randomFloat(2, 1, 2),
                'age' => $this->faker->numberBetween(18, 60),
                'observations_to_student' => $this->faker->sentence,
                'observations_to_nutritionist' => $this->faker->sentence,
                'back' => $backImage,
                'front' =>  $frontImage,
                'left' => $leftImage,
                'right' => $rightImage,
                'torax' => $this->faker->randomFloat(2, 50, 200),
                'braco_direito' => $this->faker->randomFloat(2, 20, 50),
                'braco_esquerdo' => $this->faker->randomFloat(2, 20, 50),
                'cintura' => $this->faker->randomFloat(2, 50, 200),
                'antebraco_direito' => $this->faker->randomFloat(2, 15, 30),
                'antebraco_esquerdo' => $this->faker->randomFloat(2, 15, 30),
                'abdomen' => $this->faker->randomFloat(2, 50, 200),
                'coxa_direita' => $this->faker->randomFloat(2, 30, 80),
                'coxa_esquerda' => $this->faker->randomFloat(2, 30, 80),
                'quadril' => $this->faker->randomFloat(2, 50, 200),
                'panturrilha_direita' => $this->faker->randomFloat(2, 20, 50),
                'panturrilha_esquerda' => $this->faker->randomFloat(2, 20, 50),
                'punho' => $this->faker->randomFloat(2, 10, 30),
                'biceps_femoral_direito' => $this->faker->randomFloat(2, 20, 50),
                'biceps_femoral_esquerdo' => $this->faker->randomFloat(2, 20, 50),
            ];
    }
}
