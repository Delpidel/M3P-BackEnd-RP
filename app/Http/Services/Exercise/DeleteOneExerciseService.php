<?php

namespace App\Http\Services\Exercise;

use App\Http\Repositories\ExerciseRepository;
use App\Traits\HttpResponses;

use Illuminate\Http\Response;

class DeleteOneExerciseService
{
    use HttpResponses;

    private $exerciseRepository;

    public function __construct(ExerciseRepository $exerciseRepository)
    {
        $this->exerciseRepository = $exerciseRepository;
    }

    public function handle($id)
    {

        $exercise = $this->exerciseRepository->findOne($id);

        if (!$exercise) {
            return $this->error('Exercício não encontrado no banco de dados.', Response::HTTP_NOT_FOUND);
        }

        $this->exerciseRepository->deleteOne($exercise);

        return $this->response('', Response::HTTP_NO_CONTENT);
    }
}
