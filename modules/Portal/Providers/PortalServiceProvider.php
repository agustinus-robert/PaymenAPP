<?php

namespace Modules\Portal\Providers;

use Modules\Account\Models\User;
use Modules\Core\Models\CompanyPosition;
use Modules\Portal\Models\Employee;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class PortalServiceProvider extends ServiceProvider
{
    /**
     * @var string $moduleName
     */
    protected $moduleName = 'Portal';

    /**
     * @var string $moduleNameLower
     */
    protected $moduleNameLower = 'portal';

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__.'/../Config/'.$this->moduleNameLower.'.php',
            'modules.'.$this->moduleNameLower
        );
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->register(AuthServiceProvider::class);
        $this->app->register(RouteServiceProvider::class);
        $this->loadMigrationsFrom(__DIR__ . '/../Database/Migrations');

        $this->loadViewsFrom(__DIR__.'/../Resources/Views', $this->moduleNameLower);
        // $this->loadViewsFrom(__DIR__.'/../Resources/Components', 'x-'.$this->moduleNameLower);
        // Blade::componentNamespace('Modules\\'.$this->moduleName.'\\Resources\\Components', $this->moduleNameLower);
    }
}
