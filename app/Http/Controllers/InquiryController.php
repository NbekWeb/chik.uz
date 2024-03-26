<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Resources\OrderResource;
use App\Models\User;

class InquiryController extends Controller
{
    public function index()
    {
        $CurrentUser = auth()->user()->id;
        $user = User::findOrFail($CurrentUser);
        $user->load('posts.orders');
        $inquiries = $user->posts->flatMap(function ($post) {
            return $post->orders;
        });
        return OrderResource::collection($inquiries);
    }
    public function show($id)
    {
        $currentUser = auth()->user();
        $user = User::findOrFail($currentUser->id);
        $user->load('posts.orders');
        $orders = $user->posts->flatMap(function ($post) {
            return $post->orders;
        });
        $requestedOrder = $orders->firstWhere('id', $id);
        if ($requestedOrder) {
            return new OrderResource($requestedOrder);
        }
        return response()->json(['error' => 'Inquiry not found'], 404);
    }
}
