<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\MealPlan;
use App\Models\MealPlanSchedule;
use Exception;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class MealPlanController extends Controller
{
    public function index()
    {
        $mealPlans = MealPlan::all();
        return $mealPlans;
    }

    public function store(Request $request)
    {
        try {
            $data = $request->all();

            $request->validate([
                'description' => 'string|required',
            ]);

            $student = MealPlan::create($data);

            return $student;
        } catch (Exception $exception) {
            return $this->error($exception->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

}
