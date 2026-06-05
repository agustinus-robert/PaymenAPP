<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Modules\Account\Models\UserToken;
use Symfony\Component\HttpFoundation\Response;

class ApiKeyMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
     public function handle(Request $request, Closure $next)
    {
        // Ambil API Key dari header
        $apiKey = $request->header('X-API-KEY');
        
        // Tentukan API Key yang sah
        $userToken = UserToken::where('token', $apiKey)->first();

        if (!$userToken) {
            return response()->json(['message' => 'Unauthorized: Token not found or invalid'], Response::HTTP_UNAUTHORIZED);
        }

        return $next($request);
    }
}
