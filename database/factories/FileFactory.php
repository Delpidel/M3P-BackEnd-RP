<?php

namespace Database\Factories;

use App\Models\File;
use Illuminate\Database\Eloquent\Factories\Factory;

class FileFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = File::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->word . '.' . $this->faker->fileExtension,
            'size' => $this->faker->randomFloat(2, 100, 10000),
            'mime' => $this->faker->mimeType,
            'url' => $this->faker->url,
        ];
    }
}
