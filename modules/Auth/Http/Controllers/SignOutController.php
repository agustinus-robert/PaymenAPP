<?php

namespace Modules\Auth\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Modules\Auth\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;

class SignOutController extends Controller
{
    /**
     * The user has logged out of the application.
     */
    public function destroy(Request $request)
    {
      //  $request->user()->token()->revoke();
        
        Cache::flush();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect(request('next', config('app.url')));
    }
}
