<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\MealPlanSchedule;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

class MealPlanScheduleController extends Controller
{
    public function index()
    {
        $meals = MealPlanSchedule::all();
        return $meals;
    }

    public function store(Request $request)
    {

        try {
            DB::beginTransaction();

            $data = $request->all();

            $request->validate([
                'meal_plan_id' => 'int|required',
                'hour' => 'string',
                'title' => 'string|required',
                'description' => 'string|required',
                'day' => 'required|in:SEGUNDA,TERCA,QUARTA,QUINTA,SEXTA,SABADO,DOMINGO',
            ]);

            DB::commit();

            $student = MealPlanSchedule::create($data);

            return $student;
        } catch (Exception $exception) {
             DB::rollback();
            return $this->error($exception->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    public function destroy(Request $request, $id)
    {

        $meals = MealPlanSchedule::find($id);

        if (!$meals) return $this->error('Dado não encontrado', Response::HTTP_NOT_FOUND);

        $meals->delete();

        return $this->response('', Response::HTTP_NO_CONTENT);
    }


    public function update($id, Request $request)
    {
        try {
            DB::beginTransaction();
            $meals = MealPlanSchedule::find($id);

            if (!$meals) return $this->error('dado nao encontrado', Response::HTTP_BAD_REQUEST);

            $meals->update($request->all());
            DB::commit();
            return $meals;
        } catch (Exception $exception) {
            DB::rollback();
            return response()->json(['message' => $exception->getMessage()], 400);
        }
    }
}
