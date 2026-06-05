<?php

namespace Modules\Account\Rules;

use Modules\Account\Models\User;
use Illuminate\Contracts\Validation\Rule;

class VerifiedEmail implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct() {}

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        return User::whereEmailAddress($value)
                        ->whereNotNull('email_verified_at')
                        ->count();
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Mohon maaf, surel Anda belum terverifikasi.';
    }
}