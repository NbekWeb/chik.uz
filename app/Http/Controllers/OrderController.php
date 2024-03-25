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
        // Retrieve orders owned by the authenticated user
        $orders = Order::where('user_id', $user->id)
            ->latest()
            ->paginate(1);
        // Return a collection of Order resources
        return OrderResource::collection($orders);
    }

    public function show(Request $request, $id)
    {
        $user = $request->user();
        $order = Order::findOrFail($id);
        if ($user->orders->contains('id', $order->id)) {
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
        } else {
            return response()->json(['error' => 'Unauthorized'], 403);
        }
    }

    private function setOrder($userId, $postId)
    {
        // saving order to the base and set status
        // status codes are 200, 201, 202
        // 200 order confirmed by freelancer to work on it
        // 201 order prompted to do freelancer
        // 202 order completed successfully
        // 203 order rejected by client due to failure or mishandling
        // 204 order rejected by freelancer
        Order::create([
            "user_id" => $userId,
            "post_id" => $postId,
            "status" => 201 // Assuming default status is 201
        ]);
    }

    public function cancelOrder($orderId)
    {
        // Find the order by ID
        $order = Order::findOrFail($orderId);

        // Check if the authenticated user is authorized to cancel the order
        if (auth()->user()->id === $order->user_id) {
            // Check if the order is in a cancelable state (e.g., pending or in progress)
            if ($order->status == 200 || $order->status == 201) {
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
}
