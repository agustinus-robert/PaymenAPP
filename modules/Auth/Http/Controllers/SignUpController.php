<?php

namespace Modules\Auth\Http\Controllers;

use Illuminate\Support\Facades\Http;
use Modules\Account\Models\User;
use Modules\Account\Notifications\SendEmailVerificationLinkNotification;
use Modules\Auth\Events\SignedUp;
use Modules\Auth\Http\Controllers\Controller;
use Modules\Auth\Http\Requests\SignUp\StoreRequest;

class SignUpController extends Controller
{
    /**
     * Storing newly registered user into database and do sign in.
     */
    public function store(StoreRequest $request)
    {
        $user = new User($request->transformed());

        if ($user->save()) {

            event(new SignedUp($user));

            return redirect()->intended($request->get('next', route('account::home')))->with('success', __('auth::signup.success', ['name' => $user->name]));
        }

        return redirect()->back()->withInput();
    }
}