<?php

namespace App\Http\Controllers;

use App\Http\Requests\ValidateExerciseRequest;
use App\Http\Services\Exercise\CreateExerciseService;

use App\Traits\HttpResponses;

use Illuminate\Support\Facades\Auth;

use App\Http\Services\Exercise\DeleteOneExerciseService;


class ExerciseController extends Controller
{
    use HttpResponses;

    public function store(
        ValidateExerciseRequest $validateExerciseRequest,
        CreateExerciseService $createExerciseService
    ) {

        $user_id = Auth::user()->id;

        $description = $validateExerciseRequest->input('description');

        return $createExerciseService->handle($user_id, $description);
    }

    public function destroy($id, DeleteOneExerciseService $deleteOneExerciseService)
    {

        return $deleteOneExerciseService->handle($id);
    }
}
