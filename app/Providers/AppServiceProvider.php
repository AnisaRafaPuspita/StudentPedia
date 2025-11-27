<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

use App\Models\Category;
use App\Models\Province;
use App\Models\Regency;

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
        View::composer('layouts.studentpedia', function ($view) {
        $view->with('categories', Category::all());
        $view->with('provinces', Province::all());
        $view->with('regencies', Regency::all());
        });
    }
}
