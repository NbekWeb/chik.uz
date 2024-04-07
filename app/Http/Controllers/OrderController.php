<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Resources\OrderResource;
use App\Models\Order;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
            $postPrice = $post->price;
            // chek order status and existence in base
            if ($this->isOrderStatusAllowedForNewOrder($postId)) {

                // Check if the buyer has enough cash
                if ($buyer->cash >= $postPrice) {
                    // Start a database transaction
                    DB::beginTransaction();
                    try {
                        // Deduct the price from the buyer's cash
                        $buyer->decrement('cash', $postPrice);
                        // Add the price to the seller's cash
                        $post->user->increment('cash', $postPrice);
                        // Create an order
                        $this->setOrder($buyer->id, $post->id);
                        // Commit the transaction
                        DB::commit();
                        return response()->json(['message' => 'Invitation successfully delivered']);
                    } catch (\Exception $e) {
                        // Rollback the transaction on exception
                        DB::rollback();

                        return response()->json(['error' => 'Transaction failed'], 500);
                    }
                } else {
                    return response()->json(['error' => 'Insufficient funds'], 422);
                }
            }
        } else {
            return response()->json(['error' => 'Unauthorized'], 403);
        }
    }

    public function cancelOrder($orderId)
    {
        // Find the order by ID
        $order = Order::findOrFail($orderId);

        // Check if the authenticated user is authorized to cancel the order
        if (auth()->user()->id === $order->user_id) {
            // Check if the order is in a cancelable state (e.g., pending)
            if ($order->status == 201) {
                // Start a database transaction
                DB::beginTransaction();
                try {
                    // Update the order status to canceled (assuming 203 represents a canceled status)
                    $order->update(['status' => 203]);

                    // Reverse the transaction amount from seller to buyer
                    $post = $order->post;
                    $buyer = $order->user;
                    $seller = $post->user;
                    $transactionAmount = $post->price;

                    // Refund the amount to the buyer
                    $buyer->increment('cash', $transactionAmount);
                    // Reverse the amount from the seller
                    $seller->decrement('cash', $transactionAmount);

                    // Commit the transaction
                    DB::commit();

                    return response()->json(['message' => 'Order canceled successfully']);
                } catch (\Exception $e) {
                    // Rollback the transaction on exception
                    DB::rollback();

                    return response()->json(['error' => 'Failed to cancel order'], 500);
                }
            } else {
                return response()->json(['error' => 'Cannot cancel order in current state'], 422);
            }
        } else {
            return response()->json(['error' => 'Unauthorized'], 403);
        }
    }


    // save order to DB
    private function setOrder($userId, $postId)
    {
        // Order status codes:
        // const ORDER_STATUS_PENDING = 201;
        // const ORDER_STATUS_ACCEPTED = 202;
        // const ORDER_STATUS_REJECTED = 203;
        // const ORDER_STATUS_COMPLETED = 204;

        Order::create([
            "user_id" => $userId,
            "post_id" => $postId,
            "status" => 201 // Assuming default status is 201
        ]);
    }
    private function isOrderStatusAllowedForNewOrder($postId)
{
    $currentUserId = auth()->id();

    // Check if the post has been ordered
    if ($this->isPostOrdered($postId)) {

        // Retrieve the last order for the post
        $lastOrderStatus = Order::where('post_id', $postId)
            ->where('user_id', $currentUserId)
            ->orderBy('created_at', 'desc')
            ->value('status');

        // Check if the last order status is 203 or 204
        if ($lastOrderStatus == 203 || $lastOrderStatus == 204) {
            return true; // Allowed to create a new order
        } else {
            return false; // Not allowed to create a new order
        }
    } else {
        // If the post has not been ordered, return true since there are no restrictions
        return true;
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
