<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Modules\Account\Models\UserToken;
use Symfony\Component\HttpFoundation\Response;

class CheckXApiToken
{
    public function handle(Request $request, Closure $next): Response
    {
        $token = $request->header('X-API-Token');

        if (!$token) {
            return response()->json([
                'success' => false,
                'message' => 'Token tidak ditemukan pada Header X-API-Token.'
            ], 401);
        }

        $userToken = UserToken::with('user')->where('token', $token)->first();

        auth()->login($userToken->user);
        return $next($request);
    }
}
