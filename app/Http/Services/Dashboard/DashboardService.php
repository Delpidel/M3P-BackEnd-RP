<?php

namespace App\Http\Services\Dashboard;

use App\Http\Repositories\ExerciseRepository;
use App\Http\Repositories\UserRepository;

class DashboardService
{
    protected $exerciseRepository;
    protected $userRepository;

    public function __construct(ExerciseRepository $exerciseRepository, UserRepository $userRepository)
    {
        $this->exerciseRepository = $exerciseRepository;
        $this->userRepository = $userRepository;
    }

    public function getDashboardData()
    {
        $registeredExercises = $this->exerciseRepository->count();
        $exercises = $this->exerciseRepository->all();
        $profiles = $this->userRepository->getProfilesWithCount();
        
        return [
            'registered_exercises' => $registeredExercises,
            'profiles' => $profiles,
            'exercises' => $exercises,
        ];
    }
}
