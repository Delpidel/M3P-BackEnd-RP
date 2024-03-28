<?php

namespace App\Http\Services;

use App\Http\Repositories\InstructorListWorkoutRepository;
use App\Models\Student;

class InstructorListWorkoutService
{
    protected $repository;

    public function __construct(InstructorListWorkoutRepository $repository)
    {
        $this->repository = $repository;
    }

    public function listWorkouts($id)
    {
        $student = Student::find($id);
        $workouts = $this->repository->listWorkout($id);

        $workoutsByDay = [];
        $weekDays = ['SEGUNDA', 'TERCA', 'QUARTA', 'QUINTA', 'SEXTA', 'SABADO', 'DOMINGO'];

        foreach ($weekDays as $day) {
            $workoutsByDay[$day] = $workouts->where('day', $day)->isEmpty() ? [] : $workouts->where('day', $day)->all();
        }
        return [
            'student_id' => $student->id,
            'student_name' => $student->name,
            'workouts' => $workoutsByDay,
        ];
    }
}
