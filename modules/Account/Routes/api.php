<?php

use Modules\Account\Http\Controllers\API\CredentialController;
use Illuminate\Support\Facades\Route;
// Ensure to authentication first
Route::middleware('auth:api')->group(function () {
	Route::get('/user', 'UserController@me')->name('index');
});

Route::post('/login', [CredentialController::class, 'login'])->name('login');
