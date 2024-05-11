<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Resources\PostResource;
use App\Models\Category;
use App\Models\Post;
use Illuminate\Http\Request;

class CategoryPostsController extends Controller
{
    public function index(Request $request)
    {
        if ($request->category) {
            return PostResource::collection(
                Category::where('name', $request->category)
                ->firstOrFail()->posts()->latest()->paginate(12)
                ->withQueryString());
        } else if ($request->search) {
            return  PostResource::collection(Post::where('title', 'like', '%' . $request->search . '%')
                ->orWhere('body', 'like', '%' . $request->search . '%')->latest()->paginate(15)->withQueryString());
        }
    }
}
