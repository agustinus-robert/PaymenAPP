<?php

namespace Modules\Account\Http\Controllers\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Modules\Account\Http\Controllers\Controller;
use Modules\Account\Http\Requests\User\Password\UpdateRequest;
use Modules\Account\Repositories\User\PasswordRepository;

class PasswordController extends Controller
{
    use PasswordRepository;

    /**
     * Update the specified resource in storage.
     */
    public function reset(Request $request)
    {
        if (Password::sendResetLink(['email_address' => $request->user()->email_address])) {
            return redirect()->next()->with(['success' => __('auth::forgot.success')]);
        }
        return redirect()->back()->withInput()->withErrors(['email' => __('auth::forgot.error')]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRequest $request)
    {
        if ($user = $this->updatePassword($request->user(), $request->transformed()->toArray())) {

            return redirect()->back()->with('success', $user->display_name . ' password has been successfully updated.');
        }

        return redirect()->fail();
    }
}
