<?php

namespace App\Providers;

use App\Events\AttachmentEvent;
use App\Events\NewOrderCreated;
use App\Events\OrderStatusChanged;
use App\Listeners\AttachmentListener;
use App\Listeners\SendNewOrderEmail;
use App\Listeners\SendOrderStatusEmail;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        AttachmentEvent::class => [
            AttachmentListener::class,
        ],
        NewOrderCreated::class => [
            SendNewOrderEmail::class
        ],
        OrderStatusChanged::class => [
            SendOrderStatusEmail::class
        ]

    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     *
     * @return bool
     */
    public function shouldDiscoverEvents()
    {
        return false;
    }
}
