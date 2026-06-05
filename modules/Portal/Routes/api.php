<?php

use Illuminate\Support\Facades\Route;

Route::middleware('x-api-auth')->group(function () {
    Route::get('user-balance', 'FundAPIController@showUserBalance');
    Route::resource('user-fund', 'FundAPIController')->except('edit', 'update', 'destroy');

    Route::get('user-recipient', 'PayAPIController@getRecipients');
    Route::resource('user-transaction', 'PayAPIController')->except('edit', 'update', 'destroy');
});
