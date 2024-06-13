<?php

namespace App\Http\Controllers\AdminDashboardControllers;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Post;

class PostsController extends Controller
{
    public function index()
    {
        $posts = Post::orderBy('id', 'DESC')->paginate(15);
        return view('pages.superUser.posts', ['posts' => $posts]);
    }
    public function show($id)
    {
        $superUser = auth()->user()->role_id;
        $post = Post::findOrFail($id);
        $postOrders = Order::where('post_id', $post->id)->orderBy('id', 'DESC')->paginate(15);
        if ($superUser !== 1) {
            return view("errors.403");
        }
        return view('pages.superUser.post', ['post' => $post, 'postOrders' => $postOrders]);
    }
}
