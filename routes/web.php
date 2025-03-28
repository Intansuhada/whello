<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ResetPasswordController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProfileSettingsController;
use App\Http\Controllers\UserTabController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SystemSettingsController;
use App\Http\Controllers\JobTitleController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\WorkspaceSettingController;

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
    Route::get('/users/{user}/leave-plans', [UserController::class, 'getLeavePlans'])->name('users.leave-plans');
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
    Route::put('/profile/working-hours', [ProfileSettingsController::class, 'updateWorkingHours'])->name('profile.working-hours');
    Route::get('/system', [SettingsController::class, 'system'])->name('system');

    // Add this new route for leave planning
    Route::get('/leave-planning', [SystemSettingsController::class, 'leavePlanning'])->name('leave-planning');
    Route::post('/leave-planning/store', [SystemSettingsController::class, 'storeLeavePlan'])->name('leave-planning.store');
    Route::get('/leave-planning/{id}/edit', [SystemSettingsController::class, 'editLeavePlan'])->name('leave-planning.edit');
    Route::put('/leave-planning/{id}', [SystemSettingsController::class, 'updateLeavePlan'])->name('leave-planning.update');
    Route::delete('/leave-planning/{id}', [SystemSettingsController::class, 'destroyLeavePlan'])->name('leave-planning.destroy');
    Route::get('/leave/calendar', [SystemSettingsController::class, 'leaveCalendar'])->name('leave.calendar');
    Route::get('/leave/history', [SystemSettingsController::class, 'leaveHistory'])->name('leave.history');

    // Leave Planning Routes
    Route::prefix('leave')->name('leave.')->group(function() {
        Route::get('/calendar', [SystemSettingsController::class, 'leaveCalendar'])->name('calendar');
        Route::get('/history', [SystemSettingsController::class, 'leaveHistory'])->name('history');
        // Hapus route settings ini:
        // Route::get('/settings', [SystemSettingsController::class, 'leaveSettings'])->name('settings');
        Route::post('/store', [SystemSettingsController::class, 'storeLeave'])->name('store');
        Route::post('/store', [SystemSettingsController::class, 'storeLeavePlan'])->name('store');
    });
});

Route::prefix('settings/profile')->name('settings.profile.')->middleware(['auth'])->group(function () {
    Route::put('/security', [App\Http\Controllers\ProfileController::class, 'updateSecurity'])->name('security.update');
    Route::put('/notifications', [App\Http\Controllers\ProfileController::class, 'updateNotifications'])->name('notifications.update');
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
       // Route::post('/users/invite', [UserController::class, 'invite'])->name('users.invite');
        Route::get('/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
Route::delete('/{user}', [UserController::class, 'destroy'])->name('users.destroy');
 
    });

    // Profile routes
    Route::put('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/settings/profile/update', [ProfileController::class, 'update'])
         ->name('settings.profile.update');
    Route::get('/profile/basic', [ProfileController::class, 'basic'])->name('profile.basic');
    Route::get('/profile/security', [ProfileController::class, 'security'])->name('profile.security');
    Route::get('/profile/notifications', [ProfileController::class, 'notifications'])->name('profile.notifications');
    Route::get('/profile/account', [ProfileController::class, 'account'])->name('profile.account');
    Route::get('/profile/security', [ProfileController::class, 'security'])->name('profile.security');
    Route::get('/profile/account-security', [ProfileController::class, 'accountSecurity'])->name('profile.account-security');
    
    // Profile routes
    Route::prefix('profile')->name('profile.')->group(function () {
        Route::post('/notifications/update', [ProfileController::class, 'updateNotifications'])->name('notifications.update');
    });

    Route::put('/users/{user}/edit', [UserController::class, 'update'])->name('users.update');
    //Route::delete('/users/{user}/remove', [UserController::class, 'destroy'])->name('users.destroy');

    Route::get('/users/{id}/edit', [UserController::class, 'edit'])->name('users.edit');
    Route::put('/users/{id}', [UserController::class, 'update'])->name('users.update');

    Route::get('/profile/my-profile', [ProfileController::class, 'myProfile'])->name('profile.my-profile');
    Route::post('/profile/update-profile', [ProfileController::class, 'updateProfile'])->name('profile.update-profile');
    Route::delete('/profile/delete-photo', [ProfileController::class, 'deletePhoto'])->name('profile.delete-photo');

    // Job Titles Routes
    Route::prefix('job-titles')->name('job-titles.')->group(function () {
        Route::get('/', [JobTitleController::class, 'index'])->name('index');
        Route::post('/', [JobTitleController::class, 'store'])->name('store');
        Route::get('/{id}/edit', [JobTitleController::class, 'edit'])->name('edit');
        Route::put('/{jobTitle}', [JobTitleController::class, 'update'])->name('update');
        Route::delete('/{jobTitle}', [JobTitleController::class, 'destroy'])->name('destroy');
    });
});

Route::get('/settings/system', [App\Http\Controllers\SettingsController::class, 'system'])->name('settings.system');

Route::middleware(['auth'])->group(function () {
    Route::prefix('users')->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('users.index');
        Route::get('/{id}/edit', [UserController::class, 'edit'])->name('users.edit');
        Route::put('/{id}', [UserController::class, 'update'])->name('users.update');
        Route::delete('/{id}', [UserController::class, 'destroy'])->name('users.destroy');
    });
});

Route::middleware(['auth'])->group(function () {
    Route::get('/profile/basic', [ProfileController::class, 'basic'])->name('profile.basic');
    Route::put('/profile/basic', [ProfileController::class, 'updateBasic'])->name('profile.update-basic');
    Route::post('/profile/security/update', [ProfileController::class, 'updateSecurity'])
        ->name('profile.security.update')
        ->middleware('auth');
});
Route::get('/settings/system', [SettingsController::class, 'system'])->name('settings.system');

Route::prefix('settings/system')->name('system.')->group(function () {
    Route::get('/general-workspace', [SystemSettingsController::class, 'generalWorkspace'])->name('general-workspace');
    Route::get('/working-day', [SystemSettingsController::class, 'workingDay'])->name('working-day');
    Route::get('/project-utility', [SystemSettingsController::class, 'projectUtility'])->name('project-utility');
    Route::get('/time-and-expenses', [SystemSettingsController::class, 'timeAndExpenses'])->name('time-expenses');

    // Add POST routes for form submissions
    Route::post('/working-day', [SystemSettingsController::class, 'updateWorkingDay'])->name('working-day.update');
    Route::post('/project-utility', [SystemSettingsController::class, 'updateProjectUtility'])->name('project-utility.update');
    Route::post('/time-and-expenses', [SystemSettingsController::class, 'updateTimeAndExpenses'])->name('time-expenses.update');
    
    Route::put('/general-workspace', [SystemSettingsController::class, 'updateGeneralWorkspace'])
        ->name('general-workspace.update');
    Route::delete('/general-workspace/delete-logo', [SystemSettingsController::class, 'deleteCompanyLogo'])
        ->name('delete-company-logo');
    
    Route::put('/workspace', [SystemSettingsController::class, 'updateGeneralWorkspace'])
        ->name('workspace.update');

    // Add these new routes for working days
    Route::post('/working-days/add-leave', [SystemSettingsController::class, 'addLeave'])->name('working-days.add-leave');
    Route::post('/working-days/{id}/update-leave', [SystemSettingsController::class, 'updateLeave'])->name('working-days.update-leave');
    Route::delete('/working-days/{id}/delete-leave', [SystemSettingsController::class, 'deleteLeave'])->name('working-days.delete-leave');

    // Add these new routes for holidays management
    Route::post('/working-days/add-holiday', [SystemSettingsController::class, 'addHoliday'])->name('working-days.add-holiday');
    Route::put('/working-days/{id}/update-holiday', [SystemSettingsController::class, 'updateHoliday'])->name('working-days.update-holiday');
    Route::delete('/working-days/{id}/delete-holiday', [SystemSettingsController::class, 'deleteHoliday'])->name('working-days.delete-holiday');

    Route::post('/working-days/add-leave-type', [WorkingDayController::class, 'addLeaveType'])
        ->name('working-days.add-leave-type');
    Route::post('/working-days/add-holiday', [WorkingDayController::class, 'addHoliday'])
        ->name('working-days.add-holiday');

    // Leave Types Routes
    Route::get('/leave-types/create', [SystemSettingsController::class, 'createLeaveType'])->name('leave-types.create');
    Route::post('/leave-types', [SystemSettingsController::class, 'storeLeaveType'])->name('leave-types.store');
    
    // Holidays Routes
    Route::get('/holidays/create', [SystemSettingsController::class, 'createHoliday'])->name('holidays.create');
    Route::post('/holidays', [SystemSettingsController::class, 'storeHoliday'])->name('holidays.store');

    // Leave Types Routes
    Route::get('/leave-types/{id}/edit', [SystemSettingsController::class, 'editLeaveType'])->name('leave-types.edit');
    Route::put('/leave-types/{id}', [SystemSettingsController::class, 'updateLeaveType'])->name('leave-types.update');
    Route::post('/leave-types/{id}/destroy', [SystemSettingsController::class, 'destroyLeaveType'])->name('leave-types.destroy');
    
    // Holidays Routes
    Route::get('/holidays/{id}/edit', [SystemSettingsController::class, 'editHoliday'])->name('holidays.edit');
    Route::put('/holidays/{id}', [SystemSettingsController::class, 'updateHoliday'])->name('holidays.update');
    Route::post('/holidays/{id}/destroy', [SystemSettingsController::class, 'destroyHoliday'])->name('holidays.destroy');
    Route::get('/leave-planning', [SystemSettingsController::class, 'leavePlanning'])->name('leave-planning');

    // Leave Planning Routes
    Route::get('/leave-planning', [SystemSettingsController::class, 'leavePlanning'])->name('leave-planning');
    Route::post('/leave-planning', [SystemSettingsController::class, 'updateLeavePlanning'])->name('leave-planning.update');
    Route::get('/leave-planning/{id}/edit', [SystemSettingsController::class, 'editLeavePlanning'])->name('leave-planning.edit');
    Route::delete('/leave-planning/{id}', [SystemSettingsController::class, 'destroyLeavePlanning'])->name('leave-planning.destroy');

    // Leave Planning Routes
    Route::get('/leave-planning', [SystemSettingsController::class, 'leavePlanning'])->name('leave-planning');
    Route::post('/leave-planning/store', [SystemSettingsController::class, 'storeLeavePlan'])->name('leave-planning.store');
    Route::get('/leave-planning/{id}/edit', [SystemSettingsController::class, 'editLeavePlan'])->name('leave-planning.edit');
    Route::put('/leave-planning/{id}', [SystemSettingsController::class, 'updateLeavePlan'])->name('leave-planning.update');
    Route::delete('/leave-planning/{id}', [SystemSettingsController::class, 'destroyLeavePlan'])->name('leave-planning.destroy');

    // Consolidate all leave-related routes
    Route::prefix('leave')->name('leave.')->group(function () {
        Route::get('/calendar', [SystemSettingsController::class, 'leaveCalendar'])->name('calendar');
        Route::get('/history', [SystemSettingsController::class, 'leaveHistory'])->name('history');
        
        // Leave Types
        Route::get('types/create', [SystemSettingsController::class, 'createLeaveType'])->name('types.create');
        Route::post('types', [SystemSettingsController::class, 'storeLeaveType'])->name('types.store');
        Route::get('types/{id}/edit', [SystemSettingsController::class, 'editLeaveType'])->name('types.edit');
        Route::put('types/{id}', [SystemSettingsController::class, 'updateLeaveType'])->name('types.update');
        Route::delete('types/{id}', [SystemSettingsController::class, 'destroyLeaveType'])->name('types.destroy');

        // Holidays
        Route::get('holidays/create', [SystemSettingsController::class, 'createHoliday'])->name('holidays.create');
        Route::post('holidays', [SystemSettingsController::class, 'storeHoliday'])->name('holidays.store');
        Route::get('holidays/{id}/edit', [SystemSettingsController::class, 'editHoliday'])->name('holidays.edit');
        Route::put('holidays/{id}', [SystemSettingsController::class, 'updateHoliday'])->name('holidays.update');
        Route::delete('holidays/{id}', [SystemSettingsController::class, 'destroyHoliday'])->name('holidays.destroy');

        // Leave Planning
        Route::get('planning', [SystemSettingsController::class, 'leavePlanning'])->name('planning');
        Route::get('planning/{id}/edit', [SystemSettingsController::class, 'editLeavePlan'])->name('planning.edit');
        Route::put('planning/{id}', [SystemSettingsController::class, 'updateLeavePlan'])->name('planning.update');
        Route::delete('planning/{id}', [SystemSettingsController::class, 'destroyLeavePlan'])->name('planning.destroy');
        
        // Add this missing route
        Route::post('/store', [SystemSettingsController::class, 'storeLeave'])->name('store');
        Route::get('/create', [SystemSettingsController::class, 'createLeave'])->name('create'); // Add this line
    });
});

// Add these routes inside your web.php file
Route::prefix('system/working-days')->group(function () {
    Route::post('/add-leave-type', [WorkingDayController::class, 'addLeaveType'])->name('system.working-days.add-leave-type');
    Route::post('/add-holiday', [WorkingDayController::class, 'addHoliday'])->name('system.working-days.add-holiday');
    Route::delete('/leave-type/{id}', [WorkingDayController::class, 'deleteLeaveType'])->name('system.working-days.delete-leave-type');
    Route::delete('/holiday/{id}', [WorkingDayController::class, 'deleteHoliday'])->name('system.working-days.delete-holiday');
});

Route::get('/job-titles', [JobTitleController::class, 'index'])->name('job-titles.index');
Route::get('/settings/system/partials/create', [JobTitleController::class, 'create'])->name('job-titles.create');
Route::get('/settings/system/partials/edit/{jobTitle}', [JobTitleController::class, 'edit'])->name('job-titles.edit');
Route::put('/job-titles/{jobTitle}', [JobTitleController::class, 'update'])->name('job-titles.update');
Route::delete('/job-titles/{jobTitle}', [JobTitleController::class, 'destroy'])->name('job-titles.destroy');

// Departments Routes
Route::get('/settings/system/partials/createDepart', [DepartmentController::class, 'create'])->name('department.createDepart');
Route::get('/settings/system/partials/editDepart/{department}', [DepartmentController::class, 'edit'])->name('department.editDepart');
Route::put('/departments/{department}', [DepartmentController::class, 'update'])->name('department.updateDepart');
Route::post('/departments', [DepartmentController::class, 'store'])->name('departments.store');

Route::delete('/department/{department}', [DepartmentController::class, 'destroy'])->name('department.destroyDepart');

Route::resource('departments', DepartmentController::class);

// Leave Planning Routes
Route::post('/system/leave/plan/store', [SystemSettingsController::class, 'storeLeavePlan'])->name('system.leave.plan.store');

Route::prefix('settings')->name('settings.')->group(function () {
    // Leave routes
    Route::prefix('leave')->name('leave.')->group(function () {
        Route::get('/calendar', [SystemSettingsController::class, 'leaveCalendar'])->name('calendar');
        Route::get('/history', [SystemSettingsController::class, 'leaveHistory'])->name('history');
        Route::post('/store', [SystemSettingsController::class, 'storeLeavePlan'])->name('store'); // Add this line
        Route::get('/book', [SystemSettingsController::class, 'bookLeave'])->name('book'); // Changed from create to book
    });
});

// Add these routes:
Route::get('/users/{user}/leave-planner', [UserController::class, 'leavePlanner'])->name('users.leave-planner');
Route::patch('/leave-plans/{id}/status', [UserController::class, 'updateLeaveStatus'])->name('leave.update-status');
Route::get('/users/{user}/leave-plans', [UserController::class, 'getLeavePlans'])->name('users.leave-plans');

Route::middleware(['auth'])->group(function () {
    // User routes
    Route::prefix('users')->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('users.index');
        Route::get('/{user}', [UserController::class, 'show'])->name('users.show'); // Add this route first
        Route::get('/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
        Route::put('/{user}', [UserController::class, 'update'])->name('users.update');
        Route::delete('/{user}', [UserController::class, 'destroy'])->name('users.destroy');
        Route::get('/{user}/leave-plans', [UserController::class, 'getLeavePlans'])->name('users.leave-plans');
        
        // Tab routes
        Route::get('/{user}/overview', [UserController::class, 'overview'])->name('users.overview');
        Route::get('/{user}/client', [UserController::class, 'client'])->name('users.client');
        Route::get('/{user}/project', [UserController::class, 'project'])->name('users.project');
        Route::get('/{user}/task', [UserController::class, 'task'])->name('users.task');
        Route::get('/{user}/leave-planner', [UserController::class, 'leavePlanner'])->name('users.leave-planner');
        Route::get('/{user}/time-sheets', [UserController::class, 'timeSheets'])->name('users.time-sheets');
        Route::get('/{user}/activities', [UserController::class, 'activities'])->name('users.activities');
        Route::get('/{user}/access', [UserController::class, 'access'])->name('users.access');
    });
});

