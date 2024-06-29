<?php

namespace App\Providers;

use App\Http\Resources\ChatResource;
use Illuminate\Support\ServiceProvider;
use App\Models\Chat;
use App\Models\Order;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
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
        View::composer('*', function ($view) {
            if (Auth::check()) {
                $user = Auth::user();
                $posts = Post::where('user_id', $user->id)->with('orders.chats')->get();
                $notifications = collect();

                foreach ($posts as $post) {
                    foreach ($post->orders as $order) {
                        $unreadChats = $order->chats()->where('status', false)
                            ->where('user_id', '!=', $user->id)->get();
                        foreach ($unreadChats as $chat) {
                            $chat->url = "/inquiry/{$order->id}";
                        }
                        $notifications = $notifications->merge($unreadChats);
                    }
                }

                $userOrders = $user->orders()->with('chats')->get();
                foreach ($userOrders as $order) {
                    $unreadChats = $order->chats()->where('status', false)
                        ->where('user_id', '!=', $user->id)->get();
                    foreach ($unreadChats as $chat) {
                        $chat->url = "/order/{$order->id}";
                    }
                    $notifications = $notifications->merge($unreadChats);
                }

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
