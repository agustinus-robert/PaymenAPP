<?php

namespace Modules\Auth\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use App\Providers\RouteServiceProvider;
use Modules\Auth\Http\Controllers\Controller;

class ConfirmationController extends Controller
{
    /**
     * Create a new user instance after a valid registration.
     */
    protected function store(Request $request)
    {
        if (! Hash::check($request->password, $request->user()->password)) {
            throw ValidationException::withMessages([
                'password' => __('auth.password'),
            ]);
        }

        $request->session()->passwordConfirmed();

        return redirect()->intended($request->get('next', RouteServiceProvider::HOME));
    }
}
