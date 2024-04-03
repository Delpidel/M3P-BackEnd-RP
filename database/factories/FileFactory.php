<?php

namespace Database\Factories;

use App\Models\File;
use Illuminate\Database\Eloquent\Factories\Factory;

class FileFactory extends Factory
{
    protected $model = File::class;

    public function definition()
    {
        return [
            'name' => $this->faker->word . '.jpg',
            'size' => $this->faker->numberBetween(1000, 5000),
            'mime' => 'image/jpeg',
            'url' => $this->faker->imageUrl(),
        ];
    }
}
