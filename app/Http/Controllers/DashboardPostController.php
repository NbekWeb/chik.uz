<?php

namespace App\Http\Controllers;

use App\Http\Resources\PostResource;
use App\Models\Post;
use Illuminate\Http\Request;

class DashboardPostController extends Controller
{
    public function index()
    {
        // this returns only user own posts
        return PostResource::collection(
            Post::where('user_id', auth()->user()->id)->latest()->get()
        );
    }
}
