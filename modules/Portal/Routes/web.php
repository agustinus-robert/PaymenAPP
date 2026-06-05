<?php

use Illuminate\Support\Facades\Route;
use App\Http\Middleware\PortalMiddleware;

Route::middleware(['auth', \Modules\Portal\Http\Middleware\AccessMiddleware::class])->group(function () {
    Route::resource('dashboard', 'DashboardController');
});
