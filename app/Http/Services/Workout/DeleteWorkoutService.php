<?php

namespace App\Http\Services\Workout;

use App\Http\Repositories\Workout\DeleteWorkoutRepository;
use App\Models\Workout;

class DeleteWorkoutService
{
    private $deleteWorkoutRepository;

    public function __construct(DeleteWorkoutRepository $deleteWorkoutRepository)
    {
        $this->deleteWorkoutRepository = $deleteWorkoutRepository;
    }

    public function handle($id)
    {
        $workout = Workout::find($id);

        $this->deleteWorkoutRepository->deleteOne($workout);
    }
}
