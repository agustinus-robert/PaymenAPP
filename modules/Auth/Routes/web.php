<?php

use Illuminate\Support\Facades\Route;
use Modules\Auth\Http\Middleware\AllowSignUpMiddleware;

// Redirect
Route::get('/', fn () => redirect()->route('auth::signin'))->name('index');

// Guest page
Route::middleware('guest')->group(function () {

    // Sign in
    // Route::view('/signin', 'auth::signin')->name('signin');
    // Route::post('/signin', 'SignInController@store')->name('signin');

    // Sign up
  //  Route::middleware(AllowSignUpMiddleware::class)->group(function () {
        // Route::view('/signup', 'auth::signup')->name('signup');
        // Route::post('/signup', 'SignUpController@store')->name('signup');
  //  });

    // Forgot
    // Route::view('/forgot', 'auth::forgot')->name('forgot');
    // Route::post('/forgot', 'ForgotController@store')->name('forgot');

    // Empower
    Route::get('/empower', 'OAuth\EmpowerController@redirect')->name('empower');
    Route::get('/empower/callback', 'OAuth\EmpowerController@callback')->name('empower.callback');
});

// Broker
// Route::view('/broker', 'auth::broker')->name('broker');
// Route::patch('/broker', 'BrokerController@update')->name('broker');

// Auth page
// Route::middleware('auth')->group(function () {

//     // Confirmation
//     Route::view('/confirm', 'auth::confirm')->name('confirm');
//     Route::post('/confirm', 'ConfirmationController@store')->name('confirm');

//     // Sign out
//     Route::post('/signout', 'SignOutController@destroy')->name('signout');
// });
