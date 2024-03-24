<?php

namespace App\Http\Repositories;

use App\Interfaces\ExerciseRepositoryInterface;
use App\Models\Exercise;

class ExerciseRepository implements ExerciseRepositoryInterface
{

    public function createExercise($userId, $description)
    {
        return Exercise::create([
            'user_id' => $userId,
            'description' => $description
        ]);
    }

    public function findExerciseByUserIdAndDescription($userId, $description)
    {
        return Exercise::where('user_id', $userId)
            ->where('description', $description)
            ->first();
    }
}
