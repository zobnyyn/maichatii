<?php

namespace App\Providers;

use App\Composers\TestComposer;
use Illuminate\Support\Facades\Route;
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
        Route::pattern('id', '[0-9]+');
        \Illuminate\Support\Facades\View::share('site_title', 'SITE_TITLE');
        \Illuminate\Support\Facades\View::composer('home.contact', TestComposer::class);
    }
}
