<?php

namespace Modules\Portal\Providers;

use Modules\Account\Models;
use Modules\Account\Policies;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Modules\Account\Models\User;
use Illuminate\Support\Facades\Gate;


class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
    ];
    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        \Illuminate\Support\Facades\Gate::before(function ($user) {
            if (method_exists($user, 'hasRole')) {
                if ($user->hasRole('administrator')) {
                    return true;
                }
            }
            return null;
        });
    }
}
