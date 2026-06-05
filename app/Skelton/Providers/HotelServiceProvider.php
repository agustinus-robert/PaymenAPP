<?php

// namespace Modules\Hotel\Providers;

// use Modules\Account\Models\User;
// use Modules\Core\Models\CompanyPosition;
// use Modules\HRMS\Models\Employee;
// use Modules\HRMS\Models\EmployeePosition;
// use Illuminate\Support\Facades\Blade;
// use Illuminate\Support\ServiceProvider;
// use Modules\Core\Models\CompanyInsurancePrice;

// class HRMSServiceProvider extends ServiceProvider
// {
//     /**
//      * @var string $moduleName
//      */
//     protected $moduleName = 'Hotel';

//     /**
//      * @var string $moduleNameLower
//      */
//     protected $moduleNameLower = 'hotel';

//     /**
//      * Register any application services.
//      */
//     public function register()
//     {
//         $this->mergeConfigFrom(
//             __DIR__ . '/../Config/' . $this->moduleNameLower . '.php',
//             'modules.' . $this->moduleNameLower
//         );
//     }

//     /**
//      * Bootstrap any application services.
//      */
//     public function boot()
//     {
//         $this->app->register(RouteServiceProvider::class);
//         $this->app->register(AuthServiceProvider::class);

//         $this->loadDynamicRelationships();

//         $this->loadMigrationsFrom(__DIR__ . '/../Database/Migrations');

//         $this->loadViewsFrom(__DIR__ . '/../Resources/Views', $this->moduleNameLower);
//         $this->loadViewsFrom(__DIR__ . '/../Resources/Components', 'x-' . $this->moduleNameLower);

//         // $this->loadTranslationsFrom(__DIR__.'/../Resources/Lang', $this->moduleNameLower);

//         Blade::componentNamespace('Modules\\' . $this->moduleName . '\\Resources\\Components', $this->moduleNameLower);
//     }

//     /**
//      * Register dynamic relationships.
//      */
//     public function loadDynamicRelationships()
//     {}
// }
