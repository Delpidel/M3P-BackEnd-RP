<?php

namespace App\Http\Controllers;

use App\Models\Exercise;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class DashboardController extends Controller
{
    public function getDashboard()
    {
        $registeredExercises = Exercise::count();

        $profiles = User::selectRaw('profiles.name as profile_name, count(users.id) as count')
            ->join('profiles', 'users.profile_id', '=', 'profiles.id')
            ->groupBy('profiles.name')
            ->pluck('count', 'profile_name');

        return response()->json([
            'registered_exercises' => $registeredExercises,
            'profiles' => $profiles,
        ]);
    }
}
