<?php

namespace App\Http\Services\Workout;

use App\Http\Repositories\Workout\WorkoutRepository;
use App\Models\Workout;

use App\Traits\HttpResponses;

use ErrorException;

class UpdateOneWorkoutService
{
    private $workoutRepositoy;

    public function __construct(WorkoutRepository $workoutRepository)
    {
        $this->workoutRepositoy = $workoutRepository;
    }

    public function handle($id, $data)
    {
        $workout = Workout::find($id);

        if(!$workout) throw new ErrorException('workout não encontrado', 404);

        // validar erro da existencia do workout com base no id
        return $this->workoutRepositoy->updateOne($workout, $data);
    }
}
