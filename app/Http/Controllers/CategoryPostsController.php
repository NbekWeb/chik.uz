<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Resources\PostResource;
use App\Models\Category;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CategoryPostsController extends Controller
{
    public function index(Request $request)
    {
        if ($request->category) {
            return PostResource::collection(
                Category::where('name', $request->category)
                    ->firstOrFail()->posts()->latest()->paginate(12)
                    ->withQueryString()
            );
        } else if ($request->search) {
            return  PostResource::collection(Post::where('title', 'like', '%' . $request->search . '%')
                ->orWhere('body', 'like', '%' . $request->search . '%')->latest()->paginate(15)->withQueryString());
        }
    }
    public function suggested()
    {
        // Step 1: Get posts with reviews sorted by average review rating
        $postsWithReviews = Post::leftJoin('reviews', 'posts.id', '=', 'reviews.post_id')
            ->select('posts.*', DB::raw('AVG(reviews.star) as overal_review'))
            ->where('reviews.status', 1)
            ->groupBy('posts.id')
            ->orderBy('overal_review', 'desc')
            ->take(12)
            ->get();

        // Step 2: Check if we have enough unique posts, otherwise fetch additional posts
        if ($postsWithReviews->count() < 12) {
            $remainingCount = 12 - $postsWithReviews->count();

            // Step 3: Get additional posts sorted by order count
            $postsWithOrders = Post::leftJoin('orders', 'posts.id', '=', 'orders.post_id')
                ->select('posts.*', DB::raw('COUNT(orders.id) as order_count'))
                ->groupBy('posts.id')
                ->orderBy('order_count', 'desc')
                ->take($remainingCount)
                ->get();

            // Combine posts from Step 1 and Step 3, ensuring uniqueness
            $postsWithReviews = $postsWithReviews->concat($postsWithOrders)->unique('id');

            // Step 4: Check again if we still need more posts
            if ($postsWithReviews->count() < 12) {
                $remainingCount = 12 - $postsWithReviews->count();

                // Step 5: Get additional posts sorted by newest ones
                $newestPosts = Post::orderBy('created_at', 'desc')
                    ->take($remainingCount)
                    ->get();

                // Combine posts from Step 1, Step 3, and Step 5, ensuring uniqueness
                $postsWithReviews = $postsWithReviews->concat($newestPosts)->unique('id');
            }
        }

        // Step 6: Slice to limit to 12 posts and return
        $suggested = $postsWithReviews->slice(0, 12);

        return PostResource::collection($suggested);
    }
}
