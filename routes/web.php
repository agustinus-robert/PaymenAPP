<?php

use App\Http\Controllers\Auth\ForgotPasswordController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Laravel\Fortify\Http\Controllers\AuthenticatedSessionController;
use App\Http\Controllers\Auth\ChooseEducationController;
use Modules\Web\Http\Controllers\MainController;

Route::view('/email_show', 'notify/mail');

Route::get('/', [MainController::class, 'call'])
    ->defaults('controller', 'home')
    ->defaults('method', 'index');

Route::post('/login', [AuthenticatedSessionController::class, 'store'])
    ->middleware(['guest']); // ← Tanpa throttle:login

Route::post('/forgot-password', [ForgotPasswordController::class, 'store'])
    ->middleware(['guest'])
    ->name('password.email');
