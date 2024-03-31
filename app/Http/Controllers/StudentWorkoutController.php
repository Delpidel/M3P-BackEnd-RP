<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Workout;
use App\Traits\HttpResponses;

use Symfony\Component\HttpFoundation\Response;

class StudentWorkoutController extends Controller
{
    use HttpResponses;

    
    public function workoutsByStudent($studentId)
    {
        $studentId = auth()->id();    
        
        if ($studentId !== null) {
    
            $userName = User::where('id', $studentId)->value('name');
    
            $workouts = Workout::select('workouts.*', 'users_students.user_id', 'users.name as user_name', 'exercises.description')
                ->join('users_students', 'workouts.student_id', '=', 'users_students.student_id')
                ->join('exercises', 'workouts.exercise_id', '=', 'exercises.id')
                ->join('users', 'users_students.user_id', '=', 'users.id') 
                ->where('users_students.user_id', $studentId)
                ->orderBy('workouts.created_at')
                ->get();
            
            $formattingWorkouts = [
                'student_id' => $studentId, 
                'name' => $userName, 
                'workouts' => []
            ];  
    
            foreach ($workouts as $workout) {
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
    }    

}