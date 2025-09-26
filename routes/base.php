<?php

use App\Http\Controllers\Admin\AdminController as AdminAdminController;
use App\Http\Controllers\Admin\AdminGroupController as AdminAdminGroupController;
use App\Http\Controllers\Admin\AdminTeamController as AdminAdminTeamController;
use App\Http\Controllers\Admin\DatabaseController as AdminDatabaseController;
use App\Http\Controllers\Admin\IndexController as AdminIndexController;
use App\Http\Controllers\Admin\MessageController as AdminMessageController;
use App\Http\Controllers\Admin\ProfileController as AdminProfileController;
use App\Http\Controllers\Admin\ResourceController as AdminResourceController;
use App\Http\Controllers\Admin\UserController as AdminUserController;

use App\Http\Controllers\Front\IndexController as FrontIndexController;

use App\Http\Controllers\User\IndexController as UserIndexController;
use App\Http\Controllers\User\ProfileController as UserProfileController;
use App\Http\Controllers\Admin\UserGroupController as AdminUserGroupController;
use App\Http\Controllers\Admin\UserTeamController as AdminUserTeamController;

use Illuminate\Support\Facades\Route;

Route::name('front.')->group(function () {

    Route::get('/', [FrontIndexController::class, 'index'])->name('homepage');
    Route::get('/about', [FrontIndexController::class, 'about'])->name('about');
    Route::get('/contact', [FrontIndexController::class, 'contact'])->name('contact');
    Route::get('/forgot-password', [FrontIndexController::class, 'forgot_password'])->name('forgot-password');
    Route::post('/forgot-password', [FrontIndexController::class, 'forgot_password'])->name('forgot-password-submit');
    Route::get('/forgot-username', [FrontIndexController::class, 'forgot_username'])->name('forgot-username');
    Route::post('/forgot-username', [FrontIndexController::class, 'forgot_username'])->name('forgot-username-submit');
    Route::get('/login', [FrontIndexController::class, 'login'])->name('login');
    Route::post('/login', [FrontIndexController::class, 'login'])->name('login-submit');
    Route::get('/privacy-policy', [FrontIndexController::class, 'privacy_policy'])->name('privacy-policy');
    Route::get('/register', [FrontIndexController::class, 'register'])->name('register');
    Route::post('/register', [FrontIndexController::class, 'register'])->name('register-submit');
    Route::get('/reset-password/{token}/{email}', [FrontIndexController::class, 'reset_password'])->name('reset-password');
    Route::post('/reset-password/{token}/{email}', [FrontIndexController::class, 'reset_password_submit'])->name('reset-password-submit');
    Route::get('/terms-and-conditions', [FrontIndexController::class, 'terms_and_conditions'])->name('terms-and-conditions');
    Route::get('/verify-email/{token}/{email}', [FrontIndexController::class, 'email_verification'])->name('email-verification');
});

Route::middleware('web')->name('user.')->group(function () {
    Route::get('/dashboard', [UserIndexController::class, 'dashboard'])->name('dashboard');
    Route::get('/logout', [UserIndexController::class, 'logout'])->name('logout');
    Route::get('/profile/change-password', [UserProfileController::class, 'change_password'])->name('change-password');
    Route::post('/profile/change-password', [UserProfileController::class, 'change_password_submit'])->name('change-password-submit');
    Route::get('/profile', [UserProfileController::class, 'show'])->name('show');
    Route::get('/profile/edit', [UserProfileController::class, 'edit'])->name('edit');
    Route::post('/profile/update', [UserProfileController::class, 'update'])->name('update');
});

Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [AdminIndexController::class, 'index'])->name('index');
    Route::get('/login', [AdminIndexController::class, 'login'])->name('login');
    Route::post('/login', [AdminIndexController::class, 'login'])->name('login-submit');
    Route::get('/logout', [AdminIndexController::class, 'logout'])->name('logout');
    Route::get('/forgot-password', [AdminIndexController::class, 'forgot_password'])->name('forgot-password');
    Route::post('/forgot-password', [AdminIndexController::class, 'forgot_password'])->name('forgot-password-submit');
    Route::get('/forgot-username', [AdminIndexController::class, 'forgot_username'])->name('forgot-username');
    Route::post('/forgot-username', [AdminIndexController::class, 'forgot_username'])->name('forgot-username-submit');
    Route::get('/reset-password/{token}/{email}', [AdminIndexController::class, 'reset_password'])->name('reset-password');
    Route::post('/reset-password/{token}/{email}', [AdminIndexController::class, 'reset_password_submit'])->name('reset-password-submit');
});

Route::prefix('admin/profile')->middleware('admin')->name('admin.profile.')->group(function () {
    Route::get('/', [AdminProfileController::class, 'show'])->name('show');
    Route::get('change-password', [AdminProfileController::class, 'change_password'])->name('change-password');
    Route::post('change-password', [AdminProfileController::class, 'change_password_submit'])->name('change-password-submit');
    Route::get('edit', [AdminProfileController::class, 'edit'])->name('edit');
    Route::post('update', [AdminProfileController::class, 'update'])->name('update');
});

Route::prefix('admin')->middleware('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminIndexController::class, 'dashboard'])->name('dashboard');
    Route::resource('admin', AdminAdminController::class);
    Route::resource('admin-group', AdminAdminGroupController::class)->parameter('admin-group', 'admin_group');
    Route::resource('admin-team', AdminAdminTeamController::class)->parameter('admin-team', 'admin_team');
    Route::resource('database', AdminDatabaseController::class);
    Route::resource('message', AdminMessageController::class);
    Route::resource('resource', AdminResourceController::class);
    Route::resource('user', AdminUserController::class);
    Route::resource('user-group', AdminUserGroupController::class)->parameter('user-group', 'user_group');
    Route::resource('user-team', AdminUserTeamController::class)->parameter('user-team', 'user_team');
    Route::get('/user/{user}/change-password', [AdminUserController::class, 'change_password'])->name('user.change-password');
    Route::post('/user/{user}/change-password', [AdminUserController::class, 'change_password_submit'])->name('user.change-password-submit');
});

Route::prefix('admin/admin')->middleware('admin')->name('admin.admin.')->group(function () {
});
