<?php

namespace App\Providers;

use App\Exceptions\PaymeExceptionHandler;
use Carbon\Carbon;
use Illuminate\Contracts\Debug\ExceptionHandler;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        // payme exceptions
        $this->app->singleton(
            ExceptionHandler::class,
            PaymeExceptionHandler::class
        );
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Carbon::setLocale(config('app.locale'));
        Paginator::useBootstrapFour();
    }
}
