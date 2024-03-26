<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Workout;
use Illuminate\Http\Request;
use App\Traits\HttpResponses;
use Symfony\Component\HttpFoundation\Response;

class InstructorWorkoutController extends Controller
{
    public function index($id){
        try {
            $student = Student::find($id);

            $workouts = Workout::where('student_id', $student->id)
                ->orderBy('created_at', 'ASC')
                ->with(['exercise' => function ($query) {
                    $query->select('id', 'description');
                }])->paginate(4);

            $workoutsByDay = [];

            $weekDays = ['SEGUNDA', 'TERÇA', 'QUARTA', 'QUINTA', 'SEXTA', 'SÁBADO', 'DOMINGO'];

            foreach ($weekDays as $day) {
                $workoutsByDay[$day] = $workouts->where('day', $day)->isEmpty() ? [] : $workouts->where('day', $day)->all();
            }

            return [
                'student_id' => $student->id,
                'student_name' => $student->name,
                'workouts' => $workoutsByDay,
            ];
        } catch (\Exception $exception) {
            return $this->error($exception->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }
}
