<?php

namespace App\Interfaces;

interface ExerciseInstructorRepositoryInterface
{
    public function getUserExercises($userId);
}
