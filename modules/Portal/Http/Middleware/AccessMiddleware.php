<?php

namespace Modules\Portal\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class AccessMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $user = $request->user();

        if (!$request->routeIs('portal::dashboard.index')) {
            return redirect()->route('portal::dashboard.index');
        }

        return $next($request);
    }
}
