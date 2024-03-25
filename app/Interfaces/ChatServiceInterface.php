<?php

namespace App\Interfaces;

use App\Models\Order;


interface ChatServiceInterface
{
    public function createMessage($OrderId, $text);
    public function getMessages(Order $post);
}
