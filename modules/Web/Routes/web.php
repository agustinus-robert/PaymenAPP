<?php

use Illuminate\Support\Facades\Route;
use Modules\Web\Http\Controllers\EditorController;
use Modules\Web\Http\Controllers\MainController;
use Modules\Web\Http\Controllers\Electro\CartController;
use Modules\Web\Http\Controllers\Electro\ProductController;

Route::group(['middleware' => ['web']], function () {

    Route::prefix('payment')->namespace('Payment')->name('payment.')->group(function () {

        Route::resource('home-payment', 'HomeController')->except('store', 'edit', 'update', 'delete');
        Route::middleware(['auth'])->group(function () {
            Route::resource('transfer-payment', 'PayController')->except('edit', 'update', 'delete');
            Route::resource('fund-payment', 'FundController')->except('edit', 'update', 'delete');
        });

    });

    Route::any('{controller?}/{method?}/{param?}', [MainController::class, 'call'])
        ->name('web.page');
});
