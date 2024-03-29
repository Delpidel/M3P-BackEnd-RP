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
            'name' => $this->faker->word . '.jpg', // Simula um nome de arquivo
            'size' => $this->faker->numberBetween(1000, 5000), // Simula um tamanho de arquivo
            'mime' => 'image/jpeg', // Simula o tipo MIME da imagem
            'url' => $this->faker->imageUrl(), // Simula um link para a imagem
            // Outros atributos conforme necessário
        ];
    }
}
