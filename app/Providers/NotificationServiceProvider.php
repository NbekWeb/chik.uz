<?php

namespace App\Providers;

use App\Http\Resources\ChatResource;
use Illuminate\Support\ServiceProvider;
use App\Models\Chat;
use App\Models\Order;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;

class NotificationServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        // pass the data to layout
        View::composer('*', function ($view) {
            if (Auth::check()) {
                $user = Auth::user();
                $posts = Post::where('user_id', $user->id)->get();
                $orders = Order::where('user_id', $user->id)->pluck('id')->toArray();
                $notifications = Chat::whereIn('order_id', $orders)
                    ->where('status', 0)
                    ->orderBy('created_at', 'desc')
                    ->take(15)
                    ->get();

                $globalData = [
                    'notifications' => ChatResource::collection($notifications),
                ];

                $view->with($globalData);
            } else {
                $view->with(['notifications' => []]);
            }
        });
    }
}
