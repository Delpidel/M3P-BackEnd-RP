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
           
            $formattingWorkouts = [];

            foreach ($workouts as $workout) {
                $formattingWorkouts['student_id'] = $workout->student_id;
                $formattingWorkouts['name'] = $workout->name;
                
                $day = $workout->day;
                $formattingWorkouts['workouts'][$day][] = [
                    'description' => $workout->description,
                    'repetitions' => $workout->repetitions,
                    'weight' => $workout->weight,
                    'break_time' => $workout->break_time,
                    'observations' => $workout->observations,
                    'time' => $workout->time,
                    'created_at' => $workout->created_at,
                ];
            }
    
            return response()->json($formattingWorkouts);
    } catch (\Exception $exception) {
        return $this->error($exception->getMessage(), Response::HTTP_BAD_REQUEST);
    }

}
}