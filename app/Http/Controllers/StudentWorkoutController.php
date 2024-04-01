<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserStudent;
use App\Models\Workout;
use App\Traits\HttpResponses;

use Symfony\Component\HttpFoundation\Response;

class StudentWorkoutController extends Controller
{
    use HttpResponses;

    
    public function workoutsByStudent($studentId)
    {        
        $userId = auth()->id();
        
        if ($userId === null) {
            return response()->json(['error' => 'Não há usuário autenticado'], 403);
        }
       
        $userName = User::where('id', $userId)->value('name');
       
        $studentId = UserStudent::where('user_id', $userId)->value('student_id');
            
        $workouts = Workout::select(
                'workouts.*',
                'users_students.user_id',
                'users_students.student_id',
                'users.name as user_name',
                'exercises.description'
            )
            ->join('users_students', 'workouts.student_id', '=', 'users_students.student_id')
            ->join('exercises', 'workouts.exercise_id', '=', 'exercises.id')
            ->join('users', 'users_students.user_id', '=', 'users.id')
            ->where('users_students.user_id', $userId)
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
    }   
    
}