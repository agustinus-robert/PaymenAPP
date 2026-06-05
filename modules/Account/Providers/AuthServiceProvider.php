<?php

namespace Modules\Account\Providers;

use Modules\Account\Models;
use Modules\HRMS\Models as HRMSModel;
use Modules\Account\Policies;
use Modules\HRMS\Policies as HRMSPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();
    }
}
