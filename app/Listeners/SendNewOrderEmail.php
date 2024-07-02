<?php

namespace App\Listeners;

use App\Events\NewOrderCreated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;
use App\Mail\NewOrderCreatedMail;
use App\Mail\NewOrderCreatedPostOwnerMail;

class SendNewOrderEmail implements ShouldQueue
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    use InteractsWithQueue;



    /**
     * Handle the event.
     *
     * @param  \App\Events\NewOrderCreated  $event
     * @return void
     */
    public function handle(NewOrderCreated $event)
    {
        // Send email logic here
        Mail::to($event->order->user->email)->send(new NewOrderCreatedMail($event->order));
        Mail::to($event->order->post->user->email)->send(new NewOrderCreatedPostOwnerMail($event->order));
    }
}
