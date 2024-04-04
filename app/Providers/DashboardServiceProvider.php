<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Interfaces\DashboardInstructorRepositoryInterface;
use App\Http\Repositories\DashboardInstructorRepository;

class DashboardServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(DashboardInstructorRepositoryInterface::class, DashboardInstructorRepository::class);
    }

    public function boot()
    {
        //
    }
}
