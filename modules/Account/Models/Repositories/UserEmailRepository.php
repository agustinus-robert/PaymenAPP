<?php

namespace Modules\Account\Models\Repositories;

use Modules\Account\Notifications\EmailVerificationNotification;

trait UserEmailRepository
{
    /**
     * Send to email.
     */
    public function sendEmailVerification()
    {
        $link = route('account::user.email.verify', ['token' => encrypt($this->id)]);

        $this->user->notify(new EmailVerificationNotification($link));

        return true;
    }
}