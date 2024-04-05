<?php

namespace App\Http\Repositories\Workout;

use App\Interfaces\DeleteWorkoutRepositoryInterface;
use App\Models\Workout;

class DeleteWorkoutRepository implements DeleteWorkoutRepositoryInterface
{
    public function deleteOne(Workout $workout)
    {
        $workout->delete();
    }
}
