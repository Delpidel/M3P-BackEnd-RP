<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Workout;
use App\Traits\HttpResponses;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class WorkoutController extends Controller
{
    use HttpResponses;

    public function index()
    {
        try {

            $workouts = Workout::all();
            return $workouts;
        } catch (\Exception $exception) {
            return $this->error($exception->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }
   
}