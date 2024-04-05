<?php

namespace App\Http\Repositories;

use App\Interfaces\StudentMealsRepositoryInterface;
use App\Models\File;
use App\Models\MealPlans;
use App\Models\UserStudent;

class StudentMealsRepository implements StudentMealsRepositoryInterface
{

    public function getStudentId($userId)
    {
        $studentId = UserStudent::where('user_id', $userId)->value('student_id');
        return $studentId;
    }

    public function getPlans($userId)
    {
        $studentId = $this->getStudentId($userId);
        return MealPlans::query()->where('student_id', $studentId)->get();
    }

    public function getSchedule($id, $userId)
    {
        $studentId = $this->getStudentId($userId);
        return MealPlans::query()->where('student_id', $studentId)->where('id', $id)->with(['mealPlansSchedule' => function ($query) {
            $query->orderBy('hour');
        }])->first();
    }
}
