<?php

namespace App\Http\Repositories;

use App\Models\Exercise;

class ExerciseRepository
{
    public function count()
    {
        return Exercise::count();
    }

    public function all()
    {
        return Exercise::all();
    }
}