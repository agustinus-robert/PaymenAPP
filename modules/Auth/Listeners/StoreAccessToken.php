<?php

namespace Modules\Auth\Listeners;

use Illuminate\Support\Facades\Cookie;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Laravel\Passport\Passport;

class StoreAccessToken
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        // Store session into cookie
        Cookie::queue(config('auth.cookie'), json_encode($event->auth), $this->expirationTime($event->remember));
    }

    /**
     * If user check the remember checkbox, add 1 year expiration of token.
     */
    public function expirationTime(bool $remember)
    {
        return $remember ? (60 * 60 * 24 * 365) : config('session.lifetime');
    }
}
