<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\TeacherScheduleService;
use App\Services\TeacherScheduleServiceInterface;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(TeacherScheduleServiceInterface::class, TeacherScheduleService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
