<?php

namespace App\Http\Controllers;

use App\Models\Exercise;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ExerciseInstructorController extends Controller
{
    public function index()
    {
        $userId = Auth::id();

        $exercises = Exercise::where('user_id', $userId)->get(['id', 'description']);

        return response()->json($exercises);
    }
}
