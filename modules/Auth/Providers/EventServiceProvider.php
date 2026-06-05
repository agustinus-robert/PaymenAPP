<?php

namespace Modules\Auth\Providers;

use Modules\Auth\Events;
use Modules\Auth\Listeners;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Events\SignedIn::class => [
            Listeners\StoreAccessToken::class,
        ],

        Events\SignedUp::class => [
            Listeners\SignedUpNotification::class,
            Listeners\StoreAccessToken::class
        ],
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
}
