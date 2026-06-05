<?php

namespace App\Http\Middleware\Interceptor;

use Illuminate\Http\Request;

class AuthorizationInterceptor
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return void
     */
    public function __construct(Request $request)
    {
        if (!$request->expectsJson() && $request->cookie(config('auth.cookie'))) {
            $request->headers->set('Authorization', 'Bearer ' . json_decode($request->cookie(config('auth.cookie')))->access_token);
        }
    }
}
