<?php

use App\Http\Controllers\User\IndexController as UserIndexController;
use App\Http\Controllers\User\ProfileController as UserProfileController;
use App\Models\User;

use Illuminate\Support\Facades\Route;

Route::name('user.')->group(function () {
    Route::get('/forgot-password', [UserIndexController::class, 'forgot_password'])->name('forgot_password');
    Route::post('/forgot-password', [UserIndexController::class, 'forgot_password'])->name('forgot_password_submit');
    Route::get('/login', [UserIndexController::class, 'login'])->name('login');
    Route::post('/login', [UserIndexController::class, 'login'])->name('login_submit');
    Route::get('/register', [UserIndexController::class, 'register'])->name('register');
    Route::post('/register', [UserIndexController::class, 'register'])->name('register_submit');
    Route::get('/reset-password/{token}/{email}', [UserIndexController::class, 'reset_password'])->name('reset_password');
    Route::post('/reset-password/{token}/{email}', [UserIndexController::class, 'reset_password_submit'])->name('reset_password_submit');
    Route::get('/verify-email/{token}/{email}', [UserIndexController::class, 'email_verification'])->name('email_verification');
});

Route::middleware('auth')->name('user.')->group(function () {
    Route::get('/dashboard', [UserIndexController::class, 'dashboard'])->name('dashboard');
    Route::get('/logout', [UserIndexController::class, 'logout'])->name('logout');
    Route::get('/profile/change-password', [UserProfileController::class, 'change_password'])->name('change_password');
    Route::post('/profile/change-password', [UserProfileController::class, 'change_password_submit'])->name('change_password_submit');
    Route::get('/profile', [UserProfileController::class, 'show'])->name('show');
    Route::get('/profile/edit', [UserProfileController::class, 'edit'])->name('edit');
    Route::post('/profile/update', [UserProfileController::class, 'update'])->name('update');
});
