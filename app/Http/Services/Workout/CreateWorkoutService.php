<?php

namespace App\Http\Services\Workout;

use App\Http\Repositories\CreateWorkoutRepository;

class CreateWorkoutService
{
    private $createWorkoutRepository;

    public function __construct(CreateWorkoutRepository $createWorkoutRepository)
    {
        $this->createWorkoutRepository = $createWorkoutRepository;
    }

    public function handle(array $data)
    {
        return $this->createWorkoutRepository->create($data);
    }
}