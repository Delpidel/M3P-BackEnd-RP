<?php

namespace App\Http\Controllers;

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

    public function workoutsByStudent()
    {
        try {
            $workouts = Workout::orderBy('created_at')->get();
           
            $workoutsByStudent = $workouts->groupBy('student_id')->map(function ($workouts) {
                return $workouts->groupBy(function ($workout) {
                   
                    return $workout->day;
                });
            });
          
            return $workoutsByStudent;
        } catch (\Exception $exception) {
            return $this->error($exception->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }
    

}
