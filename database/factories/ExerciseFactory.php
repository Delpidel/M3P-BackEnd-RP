<?php
namespace Database\Factories;

use App\Models\Exercise;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class ExerciseFactory extends Factory
{
    protected $model = Exercise::class;

    public function definition()
    {
        $user = User::factory()->create();

        return [
            'description' => $this->faker->unique()->name(),
            'user_id' => $user->id
        ];
    }
}
