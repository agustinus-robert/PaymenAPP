<?php

return [

    'success' => 'Success, we have sent a password reset link to your email address, the link validity period is ' . (config('auth.passwords.users.expire') / 60) . ' hours.',
    'error' => 'Sorry, the email address is invalid or unverified.'

];
