<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreWorkoutRequest;
use App\Http\Services\Workout\CreateWorkoutService;
use App\Traits\HttpResponses;
use Exception;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class WorkoutController extends Controller
{
    use HttpResponses;

    public function store(StoreWorkoutRequest $request, CreateWorkoutService $createWorkoutService)
    {
        try {
            $userId = Auth::id();
            $data = $request->all();

            $workout = $createWorkoutService->handle([...$data, 'user_id' => $userId]);
            return response()->json($workout, 201);
        } catch (Exception $exception) {
            return $this->error($exception->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }
}
