<?php

namespace Modules\Auth\Http\Controllers;

use Illuminate\Support\Facades\Password;
use Modules\Auth\Http\Controllers\Controller;
use Modules\Auth\Http\Requests\Forgot\StoreRequest;

class ForgotController extends Controller
{
    /**
     * Send password broker link.
     */
    public function store(StoreRequest $request)
    {
        if (Password::sendResetLink($request->transformed())) {

            return redirect()->route('auth::signin')
                             ->with(['success' => __('auth::forgot.success')]);
        }

        return redirect()->back()
                         ->withInput()
                         ->withErrors(['email' => __('auth::forgot.error')]);
    }
}