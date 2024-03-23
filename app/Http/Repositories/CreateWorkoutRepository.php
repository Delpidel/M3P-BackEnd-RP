<?php

namespace App\Http\Repositories;

use App\Interfaces\CreateWorkoutRepositoryInterface;
use App\Models\Workout;
use Illuminate\Http\Request;

class CreateWorkoutRepository implements CreateWorkoutRepositoryInterface
{
    public function exerciseExists($studentId, $day, $exerciseId)
    {
        //verifica se o estudante em questão já possui o exercicio cadastrado à fim de evitar duplicatas.
        return Workout::where('student_id', $studentId)
            ->where('day', $day)
            ->where('exercise_id', $exerciseId)
            ->exists();
    }

    public function create(array $data)
    {
        return Workout::create($data);
    }
}