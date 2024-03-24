<?php

namespace App\Http\Controllers;

use App\Models\Workout;
use App\Traits\HttpResponses;
use App\Http\Services\Workout\DeleteWorkoutService;
use Symfony\Component\HttpFoundation\Response;

class WorkoutController extends Controller
{
    use HttpResponses;

    public function index()
    {
        try {

            $workouts = Workout::all();
            return $workouts;
        } catch (\Exception $exception) {
            return $this->error($exception->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    public function destroy($id, DeleteWorkoutService $deleteWorkoutService)
{
       $workout = Workout::find($id);

        if (!$workout) return $this->error('Treino não encontrado', Response::HTTP_NOT_FOUND);
         $deleteWorkoutService->handle($id);
         return $this->response('', Response::HTTP_NO_CONTENT);
}

}
