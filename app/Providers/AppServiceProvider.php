<?php

namespace App\Providers;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
      Paginator::useBootstrap(); // Untuk Laravel 8/9/10 dengan Bootstrap
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
