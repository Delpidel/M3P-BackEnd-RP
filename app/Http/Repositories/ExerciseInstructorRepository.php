<?php

namespace App\Http\Repositories;

use App\Http\Services\PaginationInstructorService;
use App\Interfaces\ExerciseInstructorRepositoryInterface;
use App\Models\Exercise;

class ExerciseInstructorRepository implements ExerciseInstructorRepositoryInterface
{
    protected $paginationService;

    public function __construct(PaginationInstructorService $paginationService)
    {
        $this->paginationService = $paginationService;
    }

    public function getUserExercises($userId)
    {
        $query = Exercise::where('user_id', $userId);

        // Referente a testes: Mudar esse valor '10', afeta o número de itens na página.
        return $this->paginationService->paginate($query, 20, ['id', 'description']);

    }
}
