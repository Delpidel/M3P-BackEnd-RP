<?php

namespace App\Http\Repositories;

use App\Interfaces\CreateWorkoutRepositoryInterface;
use App\Models\Workout;

class CreateWorkoutRepository implements CreateWorkoutRepositoryInterface
{
    public function create(array $data)
    {
        return Workout::create($data);
    }
}