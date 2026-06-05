<?php

namespace Modules\Auth\Http\Controllers;

use Illuminate\Support\Facades\Password;
use Modules\Auth\Http\Requests\Broker\UpdateRequest;

use Modules\Auth\Http\Controllers\Controller;

class BrokerController extends Controller
{
    /**
     * Break the user password.
     */
    public function update(UpdateRequest $request)
    {
        $status = Password::reset(
            $request->transformed(),
            function ($user) use ($request) {
                $user->forceFill([
                    'password' => $request->password
                ])->save();
            }
        );

        if ($status) {

            return redirect()->route('login')
                             ->with('success', __('auth::broker.success'));

        }

        return redirect()->route('login')
                         ->with('danger', __('auth::broker.error'));
    }
}
