<?php

namespace App\Http\Repositories;

use App\Interfaces\DashboardInstructorRepositoryInterface;
use App\Models\User;

class DashboardInstructorRepository implements DashboardInstructorRepositoryInterface
{
    public function getAmountOfStudents($userId)
    {
        $user = User::find($userId);
        return $user->students()->count();
    }

    public function getAmountOfExercises($userId)
    {
        $user = User::find($userId);
        return $user->exercises()->count();
    }
}
