<?php

namespace App\Http\Controllers;

use App\Traits\HttpResponses;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Services\InstructorListWorkoutService;

class InstructorWorkoutController extends Controller
{
    use HttpResponses;

    public function listWorkouts($id, InstructorListWorkoutService $listWorkoutService)
    {
        try {
            $workouts = $listWorkoutService->listWorkouts($id);

            return $workouts;
        } catch (\Exception $exception) {
            return $this->error($exception->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }
}
