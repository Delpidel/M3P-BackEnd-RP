<?php

namespace App\Http\Repositories;

use App\Interfaces\ExerciseRepositoryInterface;
use App\Models\Exercise;
use App\Traits\HttpResponses;

class ExerciseRepository implements ExerciseRepositoryInterface
{
    use HttpResponses;

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

    public function findOne($id)
    {
        return Exercise::find($id);
    }

    public function deleteOne($exercise)
    {
        $exercise->delete();
    }
}
