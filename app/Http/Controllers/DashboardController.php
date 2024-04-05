<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Post;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $ordersToday = $this->getTodaysOrder($user);
        $inqueriesToday = $this->getTodaysInqueries($user)->count();
        $todaysCache = $this->getTodaysCache($user);
        return view('dashboard.index', [
            'user' => $user,
            'todaysCache' => $todaysCache,
            'ordersToday' => $ordersToday,
            'inqueriesToday' => $inqueriesToday
        ]);
    }
    public function getTodaysCache($user)
    {
        $totalPrice = 0;
        $orders = $this->getTodaysInqueries($user);
        foreach ($orders as $order) {
            $post = $order->post;

            if ($post) {
                $totalPrice += $post->price;
            }
        }
        return $totalPrice;
    }


    public function getTodaysOrder($user)
    {
        $currentDate = today();
        $ordersToday = Order::where('user_id', $user->id)->whereDate('created_at', $currentDate)->count();
        return $ordersToday;
    }
    public function getTodaysInqueries($user)
    {
        $currentDate = today();
        $posts = Post::where('user_id', $user->id)->get();
        $postIds = $posts->pluck('id');
        $inqueriesToday = Order::whereIn('post_id', $postIds)->whereDate('created_at', $currentDate)->get();
        return $inqueriesToday;
    }
}
