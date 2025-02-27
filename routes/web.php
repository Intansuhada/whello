<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ResetPasswordController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProfileSettingsController;
use App\Http\Controllers\UserTabController;

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
    Route::get('/', [UserController::class, 'index'])->name('users'); // Menampilkan daftar pengguna
    Route::post('/invite', [UserController::class, 'invite'])->name('invite'); // Mengundang pengguna via email
    Route::post('/users/invite', [UserController::class, 'invite'])->name('users.invite');
    Route::get('/activate/{token}', [UserController::class, 'activateAccountView'])->name('activate.view'); // Halaman aktivasi akun
    Route::post('/activate/{token}', [UserController::class, 'activateAccount'])->name('activate.process'); // Proses aktivasi akun
    Route::get('/{id}/details', [UserController::class, 'getUserDetails'])->name('details'); // Fixed this route
    Route::put('/{id}', [UserController::class, 'update'])->name('update');
    Route::delete('/{id}', [UserController::class, 'destroy'])->name('delete');

    // Add new tab routes
    Route::get('/{id}/overview', [UserTabController::class, 'overview'])->name('tab.overview');
    Route::get('/{id}/client', [UserTabController::class, 'client'])->name('tab.client');
    Route::get('/{id}/project', [UserTabController::class, 'project'])->name('tab.project');
    Route::get('/{id}/task', [UserTabController::class, 'task'])->name('tab.task');
    Route::get('/{id}/leave-planner', [UserTabController::class, 'leavePlanner'])->name('tab.leave-planner');
    Route::get('/{id}/time-sheets', [UserTabController::class, 'timeSheets'])->name('tab.time-sheets');
    Route::get('/{id}/activities', [UserTabController::class, 'activities'])->name('tab.activities');
    Route::get('/{id}/access', [UserTabController::class, 'access'])->name('tab.access');
    Route::get('/users/{id}/details', [UserController::class, 'getUserDetails']);
});

Route::name('settings.')->prefix('settings')->group(function() {
    Route::get('/', [SettingsController::class, 'index'])->name('index');
    Route::get('/profile', [ProfileSettingsController::class, 'index'])->name('profile');
    Route::post('/profile/change-photo', [ProfileSettingsController::class, 'changePhoto'])->name('profile.change-photo');
    Route::delete('/profile/delete-photo', [ProfileSettingsController::class, 'deletePhoto'])->name('profile.delete-photo');
    Route::put('/profile/update', [ProfileSettingsController::class, 'update'])->name('profile.update');
    Route::put('/profile/change-username', [ProfileSettingsController::class, 'changeUsername'])->name('profile.change-username');
    Route::put('/profile/change-password', [ProfileSettingsController::class, 'changePassword'])->name('profile.change-password');
    Route::post('/profile/verify-new-email', [ProfileSettingsController::class, 'verifyNewEmail'])->name('profile.verify-new-email');
    Route::get('/system', [SettingsController::class, 'system'])->name('system');
});

Route::get('/activate-account/{token}', [UserController::class, 'activateAccountView'])->name('activate-account-view');
Route::post('/activate-account/{token}/activate', [UserController::class, 'activateAccount'])->name('activate-account');

Route::middleware(['auth'])->group(function () {
    // User main routes
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::get('/users/{user}/details', 'UserController@getDetails')->name('users.details');
    
    // User tab routes
    Route::prefix('users')->group(function () {
        // Tab routes dengan nama yang jelas
        Route::get('/{user}/overview', [UserController::class, 'overview'])->name('users.overview');
        Route::get('/{user}/client', [UserController::class, 'client'])->name('users.client');
        Route::get('/{user}/project', [UserController::class, 'project'])->name('users.project');
        Route::get('/{user}/task', [UserController::class, 'task'])->name('users.task');
        Route::get('/{user}/leave-planner', [UserController::class, 'leavePlanner'])->name('users.leave-planner');
        Route::get('/{user}/time-sheets', [UserController::class, 'timeSheets'])->name('users.time-sheets');
        Route::get('/{user}/activities', [UserController::class, 'activities'])->name('users.activities');
        Route::get('/{user}/access', [UserController::class, 'access'])->name('users.access');
        Route::get('/{user}/details', [UserController::class, 'getUserDetails']);
        
        // Hapus route yang duplikat, gunakan hanya satu route untuk invite
        Route::post('/users/invite', [UserController::class, 'invite'])->name('users.invite');
    });
});
