<?php

namespace Modules\HRMS\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EmployeeHasContractMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        return isset(Auth::user()->employee->contract)
            ? $next($request)
            : redirect()->route('account::home')->with('danger', 'Maaf, Anda belum memiliki hak untuk mengakses layanan Portal Karyawan, Anda telah dialihkan di halaman Akun.');
    }
}
