<?php

namespace App\Http\Controllers;

use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{

    public function index()
    {
        //
    }

    public function store(Request $request)
    {
        $request->validate([
            'order_id' => 'required|exists:orders,id',
            'post_id' => 'required|exists:posts,id',
            'star' => 'required|integer|between:1,5',
            'comment' => 'required|string|max:255',
        ]);
        $orderId = $request->order_id;
        $this->hasOrder($orderId);

        $rating = new Review();
        $rating->post_id = $request->post_id;
        $rating->user_id = auth()->user->id;
        $rating->star = $request->star;
        $rating->comment = $request->comment;
        $rating->save();

        return response()->json(['message' => 'Rating created successfully'], 201);
    }

    public function show(Review $review)
    {
        //
    }
    public function update(Request $request, $id)
    {
        $request->validate([
            'star' => 'required|integer|between:1,5',
            'comment' => 'required|string|max:255',
            'status' => 'required|integer|between:0,3',
        ]);

        $rating = Review::findOrFail($id);
        $rating->star = $request->star;
        $rating->comment = $request->comment;
        $rating->save();

        return response()->json(['message' => 'Rating updated successfully'], 200);
    }

    public function destroy(Review $review)
    {
        $review->delete();
        return response()->json(['message' => 'Review deleted successfully'], 200);
    }
    private function hasOrder($orderId)
    {
        $user = auth()->user();

        $order = $user->orders()->where('id', $orderId)->where('status', 204)->first();

        if (!$order) {
            return response()->json(['message' => 'You don\'t have access'], 403);
        }

        $existingReview = $order->reviews()->where('user_id', $user->id)->first();

        if ($existingReview) {
            return response()->json(['message' => 'You have already reviewed this order'], 403);
        }

        return true;
    }
}
