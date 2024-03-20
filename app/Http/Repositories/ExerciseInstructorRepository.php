<?php

namespace App\Http\Repositories;

use App\Interfaces\ExerciseInstructorRepositoryInterface;
use App\Models\Exercise;

class ExerciseInstructorRepository implements ExerciseInstructorRepositoryInterface
{
    public function getUserExercises($userId)
    {
        return Exercise::where('user_id', $userId)->paginate(10, ['id', 'description']);
    }
}
