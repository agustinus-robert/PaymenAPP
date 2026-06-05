<?php

namespace Modules\Auth\Providers;

use Illuminate\Support\ServiceProvider;
use Laravel\Passport\TokenRepository;

class PassportServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(TokenRepository::class, function () {
            return new CacheTokenRepository(
                \config('passport.cache.prefix'),
                \config('passport.cache.expires_in'),
                \config('passport.cache.tags', []),
                \config('passport.cache.store', \config('cache.default'))
            );
        });
    }
}