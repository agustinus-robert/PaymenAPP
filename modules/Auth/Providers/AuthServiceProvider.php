<?php

namespace Modules\Auth\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use Laravel\Passport\ClientRepository;
use Laravel\Passport\TokenRepository;
use Modules\Auth\Passport\CacheClientRepository;
use Modules\Auth\Passport\CacheTokenRepository;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * @var string $moduleName
     */
    protected $moduleName = 'Auth';

    /**
     * @var string $moduleNameLower
     */
    protected $moduleNameLower = 'auth';

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__.'/../Config/'.$this->moduleNameLower.'.php', 'modules.'.$this->moduleNameLower
        );

        $this->app->singleton(TokenRepository::class, function () {
            return new CacheTokenRepository(
                config('passport.cache.prefix'),
                config('passport.cache.expires_in'),
                config('passport.cache.tags', []),
                config('passport.cache.store', config('cache.default'))
            );
        });

        $this->app->singleton(ClientRepository::class, function ($container) {
            $config = $container->make('config')->get('passport.personal_access_client');

            return new CacheClientRepository(
                $config['id'] ?? null,
                $config['secret'] ?? null,
                config('passport.cache.prefix'),
                config('passport.cache.expires_in'),
                config('passport.cache.tags', []),
                config('passport.cache.store', config('cache.default'))
            );
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->register(EventServiceProvider::class);
        $this->app->register(RouteServiceProvider::class);

        $this->loadMigrationsFrom(__DIR__.'/../Database/Migrations');

        $this->loadViewsFrom(__DIR__.'/../Resources/Views', $this->moduleNameLower);

        $this->loadTranslationsFrom(__DIR__.'/../Lang', $this->moduleNameLower);
    }
}
