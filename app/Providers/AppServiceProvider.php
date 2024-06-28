<?php

namespace App\Providers;

use App\Exceptions\PaymeExceptionHandler;
use App\Http\Resources\OrderResource;
use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Contracts\Debug\ExceptionHandler;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\View;
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
        // pass the data to layout
        View::composer('*', function ($view) {
            $user = auth()->user();
            $notifications = Order::where('user_id', $user->id)->where('status', '!=', 204)->get();
            $globalData = [
                'notifications' =>  OrderResource::collection($notifications),
            ];

            $view->with($globalData);
        });

        Carbon::setLocale(config('app.locale'));
        Paginator::useBootstrapFour();
    }
}
