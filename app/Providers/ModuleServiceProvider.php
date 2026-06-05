<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;


class ModuleServiceProvider extends ServiceProvider
{
    /**
     * Select modules to disable.
     *
     * @return array
     */
    protected $inactive_modules = [];

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
       
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        if(file_exists(base_path('modules'))) {
            $modules = array_map(
                fn ($path) => basename($path), 
                glob(base_path('modules').'/*', GLOB_ONLYDIR)
            );

            foreach(array_diff($modules, $this->inactive_modules) as $module) {
                if(file_exists(base_path('modules/'.$module.'/Providers/'.$module.'ServiceProvider').'.php')) {
                    $this->app->register('Modules\\'.$module.'\\Providers\\'.$module.'ServiceProvider');
                }
            }
        }
    }
}
