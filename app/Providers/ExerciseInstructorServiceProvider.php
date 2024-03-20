<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Interfaces\ExerciseInstructorRepositoryInterface;
use App\Http\Repositories\ExerciseInstructorRepository;

class ExerciseInstructorServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(
            ExerciseInstructorRepositoryInterface::class,
            ExerciseInstructorRepository::class
        );
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
