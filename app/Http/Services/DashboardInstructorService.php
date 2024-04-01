<?php

namespace App\Http\Services;

use App\Interfaces\DashboardInstructorRepositoryInterface;

class DashboardInstructorService
{
    protected $repository;

    public function __construct(DashboardInstructorRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function getDashboardData($userId)
    {
        return [
            'registered_students' => $this->repository->getAmountOfStudents($userId),
            'registered_exercises' => $this->repository->getAmountOfExercises($userId),
        ];
    }
}
