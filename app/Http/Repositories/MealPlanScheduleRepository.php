<?php

namespace App\Http\Repositories;

use App\Interfaces\MealPlanScheduleRepositoryInterface;
use App\Models\MealPlanSchedule;

class MealPlanScheduleRepository implements MealPlanScheduleRepositoryInterface
{
    public function getAll()
    {
        return MealPlanSchedule::all();
    }

    public function findById($id)
    {
        return MealPlanSchedule::find($id);
    }

    public function create(array $data)
    {
        return MealPlanSchedule::create($data);
    }

    public function update($id, array $data)
    {
        $mealPlanSchedule = MealPlanSchedule::find($id);
        $mealPlanSchedule->update($data);
        return $mealPlanSchedule;
    }

    public function delete($id)
    {
        $mealPlanSchedule = MealPlanSchedule::find($id);
        $mealPlanSchedule->delete();
        return true;
    }
}
