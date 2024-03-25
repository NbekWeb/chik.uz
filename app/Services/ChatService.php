<?php

namespace App\Services;

use App\Events\NewChat;
use App\Http\Resources\ChatResource;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;

class ChatService
{
    public function createMessage($orderId, $text)
    {
        $order = Order::find($orderId);

        if (!$order) {
            return response()->json(['message' => 'Order not found!'], 404);
        }

        $userId = Auth::id();

        if ($userId !== $order->user_id) {
            return response()->json(['error' => 'You are not authorized to create messages for this order.'], 403);
        }

        $chat = $order->chats()->create([
            'text' => $text,
            'user_id' => $userId,
        ]);

        broadcast(new NewChat($chat))->toOthers();

        return new ChatResource($chat);
    }


    public function getMessages($user, Order $id)
    {
        if ($user->id !== $id->user_id) {
            return response()->json(['chat' => 'Post not found!'], 404);
        }

        return ChatResource::collection($id->chats);
    }
}
