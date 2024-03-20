<?php

namespace App\Interfaces;

use App\Models\Workout;

interface UpdateWorkoutRepositoryInterface
{

    public function updateOne(Workout $workout, $id);
}
