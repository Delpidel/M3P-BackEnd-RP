<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Services\ExerciseInstructorService;
use Illuminate\Contracts\Auth\Factory as AuthFactory;

class ExerciseInstructorController extends Controller
{
    protected $auth;
    protected $exerciseInstructorService;

    public function __construct(AuthFactory $auth, ExerciseInstructorService $exerciseInstructorService)
    {
        $this->auth = $auth;
        $this->exerciseInstructorService = $exerciseInstructorService;
    }

    public function index()
    {
        $userId = $this->auth->guard()->id();
        $exercises = $this->exerciseInstructorService->getUserExercises($userId);

        return response()->json($exercises);
    }
}
