<?php

namespace App\Listeners;

use App\Events\OrderStatusChanged;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;
use App\Mail\OrderStatusChangedMail;
use App\Mail\OrderStatusChangedPostOwnerMail;

class SendOrderStatusEmail implements ShouldQueue
{
    use InteractsWithQueue;

    public function handle(OrderStatusChanged $event)
    {
        // Send email logic here
        Mail::to($event->order->user->email)->send(new OrderStatusChangedMail($event->order));
        // send email to post owner
        Mail::to($event->order->post->user->email)->send(new OrderStatusChangedPostOwnerMail($event->order));
    }
}
