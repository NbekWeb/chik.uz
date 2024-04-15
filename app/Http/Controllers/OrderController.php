<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Resources\OrderResource;
use App\Models\Order;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        $orders = Order::where('user_id', $user->id)
            ->latest()
            ->paginate(5);
        return OrderResource::collection($orders);
    }

    public function show(Request $request, $id)
    {
        $user = $request->user();
        $order = Order::findOrFail($id);
        if ($user->orders->contains('id', $order->id) || $user->role_id == 1) {
            return new OrderResource($order->load('chats'));
        }
        return response()->json(['error' => 'Order not found'], 404);
    }

    public function buyOrder($postId)
    {
        $post = Post::with('user')->findOrFail($postId);
        $buyer = auth()->user();

        // Check if the buyer is not the post owner
        if ($buyer->id !== $post->user->id) {
            // Check if the order status allows for a new order
            $orderStatus = $this->isOrderStatusAllowedForNewOrder($postId);

            if ($orderStatus['allowed']) {
                try {
                    // Create an order
                    $orderId = $this->setOrder($buyer->id, $post->id);
                    return response()->json(['message' => 'Invitation successfully delivered', 'order_id' => $orderId]);
                } catch (\Exception $e) {
                    return response()->json(['error' => 'Failed'], 500);
                }
            } elseif ($orderStatus['existing_order_id']) {
                // User already has an existing order
                return response()->json([
                    'message' => 'You already successfully delivered invitation for this order',
                    'order_id' => $orderStatus['existing_order_id']
                ]);
            } else {
                // User is not allowed to create a new order
                return response()->json(['error' => 'Failed'], 403);
            }
        } else {
            return response()->json(['error' => 'Unauthorized'], 403);
        }
    }


    // save order to DB
    private function setOrder($userId, $postId)
    {
        // Order status codes:
        // ORDER_STATUS_CHATTING = 200;
        // ORDER_STATUS_PENDING = 201;
        // ORDER_STATUS_ACCEPTED = 202;
        // ORDER_STATUS_REJECTED = 203;
        // ORDER_STATUS_COMPLETED = 204;

        try {
            $order = Order::create([
                "user_id" => $userId,
                "post_id" => $postId,
                "status" => 200 // Assuming default status is 200
            ]);
            return $order->id;
        } catch (\Throwable $e) {
            Log::error('Order creation failed: ' . $e->getMessage());

            // Return an error response indicating the failure
            return null;
        }
    }
    private function isOrderStatusAllowedForNewOrder($postId)
    {
        $currentUserId = auth()->id();

        // Check if the post has been ordered
        if ($this->isPostOrdered($postId)) {

            // Retrieve the last order for the post
            $lastOrder = Order::where('post_id', $postId)
                ->where('user_id', $currentUserId)
                ->orderBy('created_at', 'desc')
                ->first();

            // Check if the last order status is 203 or 204
            if ($lastOrder && ($lastOrder->status == 203 || $lastOrder->status == 204)) {
                return ['allowed' => true]; // Allowed to create a new order
            } else {
                return ['allowed' => false, 'existing_order_id' => optional($lastOrder)->id]; // Not allowed to create a new order
            }
        } else {
            // If the post has not been ordered, return true since there are no restrictions
            return ['allowed' => true];
        }
    }
    private function isPostOrdered($postId)
    {
        $currentUserId = auth()->id();
        return Order::where('user_id', $currentUserId)
            ->where('post_id', $postId)
            ->exists();
    }
}
