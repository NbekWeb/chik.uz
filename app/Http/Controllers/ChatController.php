<?php

namespace App\Http\Controllers;

use App\Models\Chat;
use App\Models\Order;
use App\Services\ChatService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ChatController extends Controller
{
    public function __construct(protected ChatService $chatService)
    {
        $this->chatService = $chatService;
    }

    public function store(Request $request, $id)
    {
        return $this->chatService->createMessage($id, $request->text);
    }

    public function getMessages(Request $request, Order $id)
    {
        $user = $request->user();

        return $this->chatService->getMessages($user, $id);
    }
    public function update($id)
    {
        return $this->chatService->update($id);
    }
}
