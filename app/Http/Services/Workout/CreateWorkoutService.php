<?php

namespace App\Http\Services\Workout;

use App\Http\Repositories\CreateWorkoutRepository;
use Exception;

class CreateWorkoutService
{
    private $createWorkoutRepository;

    public function __construct(CreateWorkoutRepository $createWorkoutRepository)
    {
        $this->createWorkoutRepository = $createWorkoutRepository;
    }

    public function handle(array $data)
    {
        if ($this->createWorkoutRepository->exerciseExists($data['student_id'], $data['day'], $data['exercise_id'])) {
            throw new Exception('Exercício já cadastrado para esse dia');
        }
        return $this->createWorkoutRepository->create($data);
    }
}