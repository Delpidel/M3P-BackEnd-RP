<?php

namespace App\Http\Controllers;

use App\Models\Exercise;
use Illuminate\Http\Request;
use Illuminate\Contracts\Auth\Factory as AuthFactory;

class ExerciseInstructorController extends Controller
{
    protected $auth;

    public function __construct(AuthFactory $auth)
    {
        $this->auth = $auth;
    }

    public function index()
    {
        $userId = $this->auth->guard()->id();

        $exercises = Exercise::where('user_id', $userId)->get(['id', 'description']);

        return response()->json($exercises);
    }
}
