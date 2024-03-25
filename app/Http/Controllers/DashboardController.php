<?php

namespace App\Http\Controllers;

use App\Models\Exercise;
use App\Models\User;
use App\Traits\HttpResponses;
use Illuminate\Http\Response;

class DashboardController extends Controller
{
    use HttpResponses;

    public function getDashboard()
    {
        $registeredExercises = Exercise::count();

        $profiles = User::selectRaw('profiles.name as profile_name, count(users.id) as count')
            ->join('profiles', 'users.profile_id', '=', 'profiles.id')
            ->groupBy('profiles.name')
            ->pluck('count', 'profile_name');

        return $this->response('',Response::HTTP_OK,[
            'registered_exercises' => $registeredExercises,
            'profiles' => $profiles,
        ]);
    }
}
