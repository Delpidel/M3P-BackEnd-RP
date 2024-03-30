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
        $studentId = auth()->id();    
    
        if ($studentId !== null) {

            $workouts = Workout::select('workouts.*', 'users_students.user_id', 'exercises.description')
                ->join('users_students', 'workouts.student_id', '=', 'users_students.student_id')
                ->join('exercises', 'workouts.exercise_id', '=', 'exercises.id')
                ->where('users_students.user_id', $studentId)
                ->orderBy('workouts.created_at')
                ->get();
            
            $formattingWorkouts = [];

            foreach ($workouts as $workout) {
                $formattingWorkouts['student_id'] = $workout->student_id;
                $formattingWorkouts['user_id'] = $workout->user_id; // Agrega el id del usuario
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
        } else {
            return response()->json(['error' => 'Não há usuário autenticado'], 403);
        }
    } catch (\Exception $exception) {
        return $this->error($exception->getMessage(), Response::HTTP_BAD_REQUEST);
    }
}

}