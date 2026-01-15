<?php

use App\Http\Controllers\Admin\IndexController as AdminIndexController;
use App\Http\Controllers\Admin\ProfileController as AdminProfileController;
use App\Http\Controllers\Admin\System\AdminController as AdminSystemAdminController;
use App\Http\Controllers\Admin\System\AdminGroupController as AdminSystemAdminGroupController;
use App\Http\Controllers\Admin\System\AdminTeamController as AdminSystemAdminTeamController;
use App\Http\Controllers\Admin\System\IndexController as AdminSystemIndexController;
use App\Http\Controllers\Admin\Root\System\AdminController as AdminRootSystemAdminController;
use App\Http\Controllers\Admin\Root\System\AdminGroupController as AdminRootSystemAdminGroupController;
use App\Http\Controllers\Admin\Root\System\AdminTeamController as AdminRootSystemAdminTeamController;
use App\Http\Controllers\Admin\Root\System\DatabaseController as AdminRootSystemDatabaseController;
use App\Http\Controllers\Admin\Root\System\LogsController as AdminRootSystemLogsController;
use App\Http\Controllers\Admin\Root\System\MessageController as AdminRootMessageController;
use App\Http\Controllers\Admin\Root\System\ResourceController as AdminRootSystemResourceController;
use App\Http\Controllers\Admin\Root\System\SessionController as AdminRootSystemSessionController;
use App\Http\Controllers\Admin\Root\System\SettingsController as AdminRootSystemSettingsController;
use App\Http\Controllers\Admin\Root\System\UserController as AdminRootSystemUserController;
use App\Http\Controllers\Admin\Root\System\UserGroupController as AdminRootSystemUserGroupController;
use App\Http\Controllers\Admin\Root\System\UserTeamController as AdminRootSystemUserTeamController;
use App\Http\Controllers\Guest\IndexController as GuestIndexController;
use App\Http\Controllers\Guest\System\AdminController as GuestSystemAdminController;
use App\Http\Controllers\Guest\System\UserController as GuestSystemUserController;
use App\Http\Controllers\IndexController as SystemIndexController;
use App\Http\Controllers\User\IndexController as UserIndexController;
use App\Http\Controllers\User\ProfileController as UserProfileController;
use Illuminate\Support\Facades\Route;

Route::name('user.')->group(function () {
    Route::get('/forgot-password', [UserIndexController::class, 'forgot_password'])->name('forgot-password');
    Route::post('/forgot-password', [UserIndexController::class, 'forgot_password'])->name('forgot-password-submit');
    Route::get('/forgot-username', [UserIndexController::class, 'forgot_username'])->name('forgot-username');
    Route::post('/forgot-username', [UserIndexController::class, 'forgot_username'])->name('forgot-username-submit');
    Route::post('/login', [UserIndexController::class, 'login'])->middleware('throttle:login')->name('login-submit');
    Route::get('/login', [UserIndexController::class, 'login'])->name('login');
    Route::get('/logout', [UserIndexController::class, 'logout'])->name('logout');
    Route::get('/register', [UserIndexController::class, 'register'])->name('register');
    Route::post('/register', [UserIndexController::class, 'register'])->name('register-submit');
    Route::get('/reset-password/{token}/{email}', [UserIndexController::class, 'reset_password'])->name('reset-password');
    Route::post('/reset-password/{token}/{email}', [UserIndexController::class, 'reset_password_submit'])->name('reset-password-submit');
    Route::get('/verify-email/{token}/{email}', [UserIndexController::class, 'email_verification'])->name('email-verification');

    // protected area
    Route::middleware('user')->group(function () {

        Route::get('/dashboard', [UserIndexController::class, 'dashboard'])->name('dashboard');
        Route::get('/profile/change-password', [UserProfileController::class, 'change_password'])->name('change-password');
        Route::put('/profile/change-password', [UserProfileController::class, 'change_password_submit'])->name('change-password-submit');
        Route::get('/profile', [UserProfileController::class, 'show'])->name('show');
        Route::get('/profile/edit', [UserProfileController::class, 'edit'])->name('edit');
        Route::put('/profile/update/{user}', [UserProfileController::class, 'update'])->name('update');
    });
});

Route::get('/', [SystemIndexController::class, 'index'])->name('home');
Route::get('about', [SystemIndexController::class, 'about'])->name('about');
Route::get('contact', [SystemIndexController::class, 'contact'])->name('contact');
Route::post('contact/store', [SystemIndexController::class, 'storeMessage'])->name('contact.storeMessage');
Route::get('privacy-policy', [SystemIndexController::class, 'privacy_policy'])->name('privacy-policy');
Route::get('terms-and-conditions', [SystemIndexController::class, 'terms_and_conditions'])->name('terms-and-conditions');

Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [SystemIndexController::class, 'index'])->name('index');
    Route::get('forgot-password', [AdminIndexController::class, 'forgot_password'])->name('forgot-password');
    Route::post('forgot-password', [AdminIndexController::class, 'forgot_password'])->name('forgot-password-submit');
    Route::get('forgot-username', [AdminIndexController::class, 'forgot_username'])->name('forgot-username');
    Route::post('forgot-username', [AdminIndexController::class, 'forgot_username'])->name('forgot-username-submit');
    Route::get('login', [AdminIndexController::class, 'login'])->name('login');
    Route::post('login', [AdminIndexController::class, 'login'])->middleware('throttle:login')->name('login-submit');
});

Route::prefix('admin')->middleware('admin')->name('admin.')->group(function () {

    Route::get('/', [AdminSystemIndexController::class, 'index'])->name('index');

    Route::get('/', [AdminIndexController::class, 'index'])->name('index');
    Route::get('/dashboard', [AdminIndexController::class, 'dashboard'])->name('dashboard');
    Route::get('/logout', [AdminIndexController::class, 'logout'])->name('logout');
    Route::get('/profile', [AdminProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile/change-password', [AdminProfileController::class, 'change_password'])->name('profile.change-password');
    Route::put('/profile/change-password', [AdminProfileController::class, 'change_password_submit'])->name('profile.change-password-submit');
    Route::get('/profile/edit', [AdminProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile/update/{admin}', [AdminProfileController::class, 'update'])->name('profile.update');
    Route::get('/reset-password/{token}/{email}', [AdminIndexController::class, 'reset_password'])->name('reset-password');
    Route::post('/reset-password/{token}/{email}', [AdminIndexController::class, 'reset_password_submit'])->name('reset-password-submit');

    Route::resource('admin', AdminSystemAdminController::class);
    Route::resource('admin-group', AdminSystemAdminGroupController::class)->parameter('admin-group', 'admin_group');
    Route::resource('admin-team', AdminSystemAdminTeamController::class)->parameter('admin-team', 'admin_team');
    Route::resource('user-group', AdminSystemUserGroupController::class)->parameter('user-group', 'user_group');
    Route::resource('user-team', AdminSystemUserTeamController::class)->parameter('user-team', 'user_team');
});

Route::prefix('admin')->middleware('admin')->name('root.')->group(function () {

    Route::resource('database', AdminRootSystemDatabaseController::class);
    Route::resource('logs', AdminRootSystemLogsController::class);
    Route::resource('message', AdminRootMessageController::class);
    Route::resource('resource', AdminRootSystemResourceController::class);
    Route::resource('session', AdminRootSystemSessionController::class);
    Route::get('settings', [AdminRootSystemSettingsController::class, 'show'])->name('settings.show');
    Route::resource('user', AdminRootSystemUserController::class);
    Route::get('user/{user}/change-password', [AdminRootSystemUserController::class, 'change_password'])->name('user.change-password');
    Route::post('user/{user}/change-password', [AdminRootSystemUserController::class, 'change_password_submit'])->name('user.change-password-submit');
    Route::resource('user-group', AdminRootSystemUserGroupController::class)->parameter('user-group', 'user_group');
    Route::resource('user-team', AdminRootSystemUserTeamController::class)->parameter('user-team', 'user_team');

    Route::resource('{adminId}/admin', AdminRootSystemAdminController::class);
    Route::resource('{adminId}/admin-group', AdminRootSystemAdminGroupController::class)->parameter('admin-group', 'admin_group');
    Route::resource('{adminId}/admin-team', AdminRootSystemAdminTeamController::class)->parameter('admin-team', 'admin_team');
});

Route::get('/{admin:label}', [GuestSystemAdminController::class, 'show'])->name('guest.admin.show');

Route::name('guest.')->group(function () {
    Route::get('/user', [GuestSystemUserController::class, 'index'])->name('user.index');
    Route::get('/user/{user:id}', [GuestSystemUserController::class, 'index'])->name('user.show');
});

