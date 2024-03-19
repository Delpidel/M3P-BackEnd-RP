<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateWorkoutRequest;
use App\Http\Services\workout\UpdateOneWorkoutService;
use App\Models\Workout;
use App\Traits\HttpResponses;
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
    public function update($id, UpdateWorkoutRequest $request, UpdateOneWorkoutService $updateOneWorkoutService)
    {
        try {
            $body = $request->all();
            $workout =  $updateOneWorkoutService->handle($id, $body);
            return $workout;
        } catch (\Exception $exception) {
            return $this->error($exception->getMessage(), $exception->getCode());
        }
    }
}
