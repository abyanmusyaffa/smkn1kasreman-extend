<?php

namespace App\Providers;

use Carbon\Carbon;
use App\Models\School;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Carbon::setLocale('id');

        View::composer('livewire.layouts.app', function ($view) {
            $school = School::first();
            $view->with('name', $school->name)
                 ->with('logo', $school->logo)
                 ->with('description', $school->description);
        });
    }
}
