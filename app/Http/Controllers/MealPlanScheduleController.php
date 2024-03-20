<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\MealPlanSchedule;
use Exception;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class MealPlanScheduleController extends Controller
{
    public function store(Request $request)
    {

        try {
            $data = $request->all();

            $request->validate([
                'student_id' => 'int|required',
                'meal_plan_id' => 'int|required',
                'hour' => 'string',
                'title' => 'string|required',
                'description' => 'string|required',
                'day' => 'required|in:SEGUNDA,TERCA,QUARTA,QUINTA,SEXTA,SABADO,DOMINGO',
            ]);

            $student = MealPlanSchedule::create($data);

            return $student;
        } catch (Exception $exception) {
            return $this->error($exception->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    public function destroy(Request $request, $id)
    {
        //$user_id = $request->user()->id;

        $meals = MealPlanSchedule::find($id);

        if (!$meals) return $this->error('Dado não encontrado', Response::HTTP_NOT_FOUND);

        //if ($student->user_id !== $user_id) return $this->error('voce nao pode excluir este dado', Response::HTTP_FORBIDDEN);

        $meals->delete();

        return $this->response('', Response::HTTP_NO_CONTENT);
    }


    public function update($id, Request $request)
    {
        try {

           // $user_id = $request->user()->id;

            $meals = MealPlanSchedule::find($id);

            //if (!$student) return $this->error('dado nao encontrado', Response::HTTP_BAD_REQUEST);

           // if ($student->user_id !== $user_id) return $this->error('voce nao pode editar este dado', Response::HTTP_FORBIDDEN);

            $meals->update($request->all());

            return $meals;
        } catch (Exception $exception) {
            return response()->json(['message' => $exception->getMessage()], 400);
        }
    }
}
