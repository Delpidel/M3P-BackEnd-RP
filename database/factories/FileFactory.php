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
            'name' => $this->faker->sentence(),
            'size' => $this->faker->numberBetween(1, 10000),
            'mime' => $this->faker->mimeType,
            'url' => $this->faker->url,
        ];
    }
}
