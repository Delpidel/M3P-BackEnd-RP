<?php

namespace App\Providers;

use App\Http\Repositories\MealPlanScheduleRepository;
use App\Http\Services\MealPlanScheduleService;
use App\Interfaces\MealPlanScheduleRepositoryInterface;
use App\Interfaces\MealPlanScheduleServiceInterface;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(MealPlanScheduleRepositoryInterface::class, MealPlanScheduleRepository::class);
        $this->app->bind(MealPlanScheduleServiceInterface::class, MealPlanScheduleServiceInterface::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
