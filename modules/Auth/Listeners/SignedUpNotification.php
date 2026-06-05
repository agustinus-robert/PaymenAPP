<?php

namespace Modules\Auth\Listeners;

use Modules\Auth\Notifications\SayWelcomeNotification;
use Modules\Account\Notifications\EmailVerificationLinkNotification;

class SignedUpNotification
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
        // Send email for email verification
        $link = route('account::user.email.verify', ['token' => encrypt($event->user->email_address)]);
        $event->user->notify(new EmailVerificationLinkNotification($link));
        
        $event->user->notify(new SayWelcomeNotification($event->user));
    }
}
