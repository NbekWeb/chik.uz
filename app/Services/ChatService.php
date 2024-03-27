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
        if ($user->id == $id->user_id || $userId == $id->post->user_id) {
            return ChatResource::collection($id->chats);
        }
        return response()->json(['chat' => 'Post not found!'], 404);
    }
}
