<?php

namespace App\Http\Services;

use App\Interfaces\ExerciseInstructorRepositoryInterface;

class ExerciseInstructorService
{
    protected $exerciseInstructorRepository;

    public function __construct(ExerciseInstructorRepositoryInterface $exerciseInstructorRepository)
    {
        $this->exerciseInstructorRepository = $exerciseInstructorRepository;
    }

    public function getUserExercises($userId)
    {
        return $this->exerciseInstructorRepository->getUserExercises($userId);
    }
}
