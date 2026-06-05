<?php

namespace Modules\HRMS\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HasPositionLevelMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next, array $levels)
    {
        $position = Auth::user()->employee->position->position->level->value ?? null;
        if (in_array($position, $levels)) {
            return $next($request);
        }
        return redirect()->back()->with('danger', 'Maaf, Anda tidak memiliki hak untuk mengakses tautan/halaman yang Anda maksud.');
    }
}
