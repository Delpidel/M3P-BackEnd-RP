<?php

namespace App\Interfaces;

interface DashboardInstructorRepositoryInterface
{
    public function getAmountOfStudents($userId);
    public function getAmountOfExercises($userId);
}
