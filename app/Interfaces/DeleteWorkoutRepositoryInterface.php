<?php

namespace App\Interfaces;

use App\Models\Workout;

interface DeleteWorkoutRepositoryInterface
{
    public function deleteOne(Workout $workout);
}
