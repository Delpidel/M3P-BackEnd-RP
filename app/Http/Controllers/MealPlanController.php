<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\MealPlan;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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
            $data = $request->all();
            $request->validate([
                'student_id' => 'int|required',
                'description' => 'string|required'
            ]);

            $mealPlans = MealPlan::create($data);
            return $mealPlans;

    }
}
