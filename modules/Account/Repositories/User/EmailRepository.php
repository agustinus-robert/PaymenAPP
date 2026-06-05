<?php

namespace Modules\Account\Repositories\User;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Modules\Account\Models\User;
use Modules\Account\Notifications\EmailVerificationLinkNotification;

trait EmailRepository
{
    /**
     * Update the specified resource in storage.
     */
    public function updateEmail(User $user, array $array, $keepVerification = false)
    {
        $user->fill(Arr::only($array, ['email_address']));

        if (!$keepVerification) {
            $user->email_verified_at = null;
        }

        if ($user->save()) {

            Auth::user()->log('memperbarui alamat surel pengguna ' . $user->name . ' <strong>[ID: ' . $user->id . ']</strong>', User::class, $user->id);

            return $user;
        }

        return false;
    }

    /**
     * Send verification link to current user email.
     */
    public function sendEmailVerification(User $user)
    {
        if (isset($user->email_address)) {
            $link = route('account::user.email.verify', ['token' => encrypt($user->email_address)]);

            $user->notify(new EmailVerificationLinkNotification($link));

            Auth::user()->log('mencoba verifikasi surel ' . $user->email_address);
        }

        return true;
    }
}
