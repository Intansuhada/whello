<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ResetPasswordController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\UserController;

Route::name('auth.')->group(function() {
    Route::get('/', [AuthController::class, 'signinView'])->name('signin-page');
    Route::post('/signin', [AuthController::class, 'signin'])->name('signin');

    Route::get('/signup', [AuthController::class, 'signupView'])->name('signup-page');
    Route::post('/signup', [AuthController::class, 'signup'])->name('signup');

    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
});

Route::get('/forgot-password', [ResetPasswordController::class, 'index'])->name('forgot-password-page');

Route::post('/forgot-password', [ResetPasswordController::class, 'sendToEmailPasswordReset'])->name('send-reset-link');

Route::get('/reset-password/{token}', [ResetPasswordController::class, 'resetPasswordView'])->name('reset-password-view');

Route::post('/reset-password/{token}', [ResetPasswordController::class, 'resetPassword'])->name('reset-password');

Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

Route::name('users.')->prefix('users')->group(function() {
    Route::get('/', [UserController::class, 'index'])->name('users');
    Route::post('/', [UserController::class, 'invite'])->name('invite');
    Route::get('/{id}', [UserController::class, 'view'])->name('view');
});

Route::name('settings.')->prefix('settings')->group(function() {
    Route::get('/', function() {
        return true;
    });

    Route::get('/profile', [SettingsController::class, 'profileView'])->name('profile');

    Route::get('/system', function() {
        return view('settings.system');
    })->name('system');
});

Route::get('/activate-account/{token}', [UserController::class, 'activateAccountView'])->name('activate-account-view');
Route::post('/activate-account/{token}/activate', [UserController::class, 'activateAccount'])->name('activate-account');
