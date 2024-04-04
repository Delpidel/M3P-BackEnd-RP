<?php

namespace App\Http\Services\Exercise;

use App\Http\Repositories\ExerciseRepository;
use App\Traits\HttpResponses;

use Illuminate\Http\Response;

class CreateExerciseService
{
    use HttpResponses;

    private $exerciseRepository;

    public function __construct(ExerciseRepository $exerciseRepository)
    {
        $this->exerciseRepository = $exerciseRepository;
    }

    public function handle($userId, $description)
    {

        $existingExercise = $this->exerciseRepository->findExerciseByUserIdAndDescription($userId, $description);

        if ($existingExercise) {
            return response()->json(['message' => 'O exercício já existe para este usuário.'], Response::HTTP_CONFLICT);
        }

        return $this->exerciseRepository->createExercise($userId, $description);
    }
}
