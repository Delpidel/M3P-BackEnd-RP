<?php

namespace App\Http\Repositories\Workout;

use App\Interfaces\UpdateWorkoutRepositoryInterface;
use App\Models\Workout;

class WorkoutRepository implements UpdateWorkoutRepositoryInterface
{

    public function updateOne(Workout $workout, $data)
    {
        $workout->update($data);
        $workout->save();
        return $workout;
    }
}

