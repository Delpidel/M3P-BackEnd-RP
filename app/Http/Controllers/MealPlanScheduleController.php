<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Services\MealPlanScheduleService;
use App\Models\MealPlanSchedule;
use Illuminate\Http\Request;

class MealPlanScheduleController extends Controller
{
    private $mealPlanScheduleService;

    public function __construct(MealPlanScheduleService $mealPlanScheduleService)
    {
        $this->mealPlanScheduleService = $mealPlanScheduleService;
    }

    public function index()
    {
        return $this->mealPlanScheduleService->getAll();
    }

    public function studentMeal($id)
    {
        return $this->mealPlanScheduleService->findById($id);
    }


    public function store(Request $request)
    {
        return $this->mealPlanScheduleService->create($request);
    }

    public function destroy($id)
    {
        return $this->mealPlanScheduleService->delete($id);
    }

    public function update($id, Request $request)
    {
        return $this->mealPlanScheduleService->update($id, $request);
    }
}
