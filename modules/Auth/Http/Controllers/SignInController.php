<?php

namespace Modules\Auth\Http\Controllers;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Validation\ValidationException;
use Modules\Auth\Events\SignedIn;
use Modules\Auth\Http\Controllers\Controller;
use Modules\Auth\Http\Requests\SignIn\StoreRequest;
use Modules\Account\Models\User;
use Modules\Account\Models\UserRole;
use Modules\Account\Models\UserToken;

class SignInController extends Controller
{
    public function store(StoreRequest $request)
    {

        $request->ensureIsNotRateLimited();

        $response = Http::withOptions(['verify' => false])->post(route('passport.token'), $request->transformed());

        if ($response->ok()) {

            RateLimiter::clear($request->throttleKey());
            event(new SignedIn($response->object(), $request->has('remember')));

            $getUserNameId = User::where('username', $request->transformed()['username'])->first();
            $getRoleId = UserRole::where('user_id', $getUserNameId->id)->first();
            if ($getRoleId->role_id > 1) {
            } else {
                return redirect()->intended($request->get('next', route('account::home')));
            }
        }

        RateLimiter::hit($request->throttleKey());

        $errorMessage = isset($response->object()->error)
            ? __('auth::signin.' . $response->object()->error)
            : 'Terjadi kesalahan di sisi server, silahkan hubungi kami.';

        throw ValidationException::withMessages([
            'username' => $errorMessage
        ]);
    }
}
