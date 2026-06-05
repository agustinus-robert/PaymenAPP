<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EnsureUserHasPermission
{
    public function handle(Request $request, Closure $next, $permission = null)
    {
        if (empty($permission)) {
            return $next($request);
        }

        if (Auth::check() && !Auth::user()->can($permission)) {
            return redirect()->back()->with('error_access', "Akses ditolak: Anda butuh izin untuk akses halaman ini");
        }

        return $next($request);
    }
}
