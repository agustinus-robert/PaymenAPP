<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Tenant;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;

class TenantSwitch
{
    public function handle(Request $request, Closure $next)
    {
        if (env('TENANT_PACK', false)) {
            $host = $request->getHost();
            $subdomain = explode('.', $host)[0];

            $tenant = Tenant::where('subdomain', $subdomain)->firstOrFail();

            Config::set('database.connections.tenant_pgsql.database', $tenant->database);
            DB::purge('tenant_pgsql');
            DB::reconnect('tenant_pgsql');

            $request->attributes->set('tenant', $tenant);
        }

        return $next($request);
    }
}
