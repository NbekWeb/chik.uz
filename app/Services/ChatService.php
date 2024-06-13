<?php

namespace App\Services;

use App\Events\NewChat;
use App\Http\Resources\ChatResource;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;

class ChatService
{
    const ORDER_STATUS_ChATTING = 200;
    const ORDER_STATUS_PENDING = 201;
    const ORDER_STATUS_ACCEPTED = 202;
    const ORDER_STATUS_REJECTED = 203;
    const ORDER_STATUS_COMPLETED = 204;

    public function createMessage($orderId, $text)
    {
        $order = Order::find($orderId);

        if (!$order) {
            return response()->json(['message' => 'Order not found!'], 404);
        }
        if ($order->status === self::ORDER_STATUS_COMPLETED || $order->status === self::ORDER_STATUS_REJECTED) {
            return response()->json(['error' => 'Cannot add message to this order. Order status is not suitable.'], 403);
        }
        $userId = Auth::id();

        if ($userId == $order->user_id || $userId == $order->post->user_id) {

            $chat = $order->chats()->create([
                'text' => $text,
                'user_id' => $userId,
            ]);

            broadcast(new NewChat($chat))->toOthers();

            return new ChatResource($chat);
        }
        return response()->json(['error' => 'You are not authorized to create messages for this order.'], 403);
    }


    public function getMessages($user, Order $id)
    {
        $userId = Auth::id();
        if ($user->id == $id->user_id || $userId == $id->post->user_id || $user->role_id == 1) {
            return ChatResource::collection($id->chats);
        }
        return response()->json(['chat' => 'Post not found!'], 404);
    }
}
