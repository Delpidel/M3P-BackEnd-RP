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

    public function workoutsByStudent($studentId)
    {
        try {
            $workouts = Workout::select('workouts.*', 'students.name', 'exercises.description')
            ->join('students', 'workouts.student_id', '=', 'students.id')
            ->join('exercises', 'workouts.exercise_id', '=', 'exercises.id')
            ->where('workouts.student_id', $studentId)
            ->orderBy('created_at')
            ->get();
           
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
