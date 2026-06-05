<?php

// Redirect

use Illuminate\Support\Facades\Route;

Route::get('/', fn () => redirect()->route('account::home'))->name('index');

// Auth page
Route::prefix('member')->namespace('Member')->name('member.')->group(function () {
	Route::resource('/registration', 'RegistrationAppController')->parameters(['registrations' => 'registration']);
});

Route::middleware('auth')->group(function () {

    Route::view('/home', 'account::home')->name('home');
    Route::view('/home-member', 'account::home-member')->name('home-member');
    Route::get('/account-dashboard', 'DashboardController@index')->name('account.dashboard');
    Route::resource('/manage-audit-log', 'AuditLogController')->only('index');
    Route::resource('/manage-session', 'LoginSessionController')->only('index');
    Route::resource('/manage-profile', 'ProfileController');

    // Route::name('user.')->namespace('User')->group(function () {


	// 	Route::view('/avatar', 'account::user.avatar')->name('avatar');
	// 	Route::put('/avatar', 'AvatarController@update')->name('avatar');
	// 	Route::delete('/avatar', 'AvatarController@destroy')->name('avatar');

	// 	Route::view('/email', 'account::user.email')->name('email');
	// 	Route::put('/email', 'EmailController@update')->name('email');
	// 	Route::get('/email/reverify', 'EmailController@reverify')->name('email.reverify');

	// 	Route::view('/phone', 'account::user.phone')->name('phone');
	// 	Route::put('/phone', 'PhoneController@update')->name('phone');
	// 	Route::delete('/phone', 'PhoneController@destroy')->name('phone');

	// 	Route::view('/password', 'account::user.password')->name('password');
	// 	Route::put('/password', 'PasswordController@update')->name('password');
	// 	Route::post('/password/reset', 'PasswordController@reset')->name('password.reset');
	// });

	// Route::view('/notifications', 'account::notifications')->name('notifications');
	// Route::get('/notifications/read-all', 'NotificationController@readAll')->name('notifications.read-all');
	// Route::get('/notifications/{id}', 'NotificationController@read')->name('notifications.read');
});

Route::get('/email/verify', 'User\EmailController@verify')->name('user.email.verify');
