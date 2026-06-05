<?php

namespace App\Models\Traits\Cacheable\Providers;

use App\Models\Traits\Cacheable\Console\Commands\Clear;
use App\Models\Traits\Cacheable\Console\Commands\Publish;
use App\Models\Traits\Cacheable\Helper;
use App\Models\Traits\Cacheable\ModelCaching;
use Illuminate\Support\ServiceProvider;

class Service extends ServiceProvider
{
    protected $defer = false;

    public function boot()
    {
        $configPath = __DIR__ . '/../../config/laravel-model-caching.php';
        $this->mergeConfigFrom($configPath, 'laravel-model-caching');
        $this->commands([
            Clear::class,
            Publish::class,
        ]);
        $this->publishes([
            $configPath => config_path('laravel-model-caching.php'),
        ], "config");
    }

    public function register()
    {
        if (! class_exists('App\Models\Traits\Cacheable\EloquentBuilder')) {
            class_alias(
                ModelCaching::builder(),
                'App\Models\Traits\Cacheable\EloquentBuilder'
            );
        }

        $this->app->bind("model-cache", Helper::class);
    }
}
