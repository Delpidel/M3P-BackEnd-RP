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
    public function index($id)
    {
        $mealPlans = MealPlan::all();
        return $mealPlans;
    }

    public function store(Request $request)
    {

        try {
            DB::beginTransaction();
            $data = $request->all();

            $request->validate([
                'description' => 'string|required',
            ]);

            $mealPlans = MealPlan::create($data);
            DB::commit();
            return $mealPlans;
        } catch (Exception $exception) {
            DB::rollback();
            return $this->error($exception->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }
}
