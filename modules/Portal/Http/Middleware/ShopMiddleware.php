<?php

namespace Modules\Portal\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class ShopMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (Gate::forUser($request->user())->allows('is-supplier')) {
            return redirect()->route('poz::supplier.dashboard');
        }

        if (!Gate::forUser($request->user())->allows('is-casier')) {
            return redirect()->route('portal::dashboard-msdm.index');
        }

        return $next($request);
    }
}
