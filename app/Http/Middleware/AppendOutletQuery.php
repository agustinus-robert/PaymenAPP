<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\URL;

class AppendOutletQuery
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!empty($request->user()->current_team_id) && $request->user()->current_team_id == 1) {
            $outlet = $request->query('outlet');

            // Jika ada outlet, tambahkan ke setiap URL yang dibuat oleh route() dan url()
            if ($outlet) {
                URL::defaults(['outlet' => $outlet]);
            }
        }

        return $next($request);
    }
}
