<?php

namespace App\Http\Controllers\AdminDashboardControllers;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Post;
use Illuminate\Http\Request;

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
    public function update(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|boolean'
        ]);
        $post = Post::findOrFail($id);
        $post->is_active = $request->status;
        $post->save();
        return response()->json(['message' => 'Post status updated successfully'], 200);
    }
}
