<?php


namespace App\Http\Repositories;

use App\Interfaces\InstructorListWorkoutRepositoryInterface;
use App\Models\Workout;

class InstructorListWorkoutRepository implements InstructorListWorkoutRepositoryInterface
{

    public function listWorkout($id)
    {

        $workouts = Workout::where('student_id', $id)
            ->orderBy('created_at', 'ASC')
            ->with(['exercise' => function ($query) {
                $query->select('id', 'description');
            }])
            ->get();



        return $workouts;
    }
}
