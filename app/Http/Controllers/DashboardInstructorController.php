<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Exercise;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardInstructorController extends Controller
{
    public function index(Request $request)
    {
        try {
            $user = Auth::user();
            $amountStudents = $user->students()->count();
            $amountExercises = $user->exercises()->count();

            return response()->json([
                'registered_students' => $amountStudents,
                'registered_exercises' => $amountExercises
            ], 200);

        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
