<?php

use App\Http\Controllers\User\IndexController;
use App\Models\User;

use Illuminate\Support\Facades\Route;

Route::get('/forgot-password', [IndexController::class, 'forgot_password'])->name('forgot_password');
Route::post('/forgot-password', [IndexController::class, 'forgot_password'])->name('forgot_password_submit');
Route::get('/login', [IndexController::class, 'login'])->name('login');
Route::post('/login', [IndexController::class, 'login'])->name('login_submit');
Route::get('/register', [IndexController::class, 'register'])->name('register');
Route::post('/register', [IndexController::class, 'register'])->name('register_submit');
Route::get('/reset-password/{token}/{email}', [IndexController::class, 'reset_password'])->name('reset_password');
Route::post('/reset-password/{token}/{email}', [IndexController::class, 'reset_password_submit'])->name('reset_password_submit');
Route::get('/verify-email/{token}/{email}', [IndexController::class, 'email_verification'])->name('email_verification');

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [IndexController::class, 'dashboard'])->name('dashboard');
    Route::get('/logout', [IndexController::class, 'logout'])->name('logout');
    Route::get('/profile', [IndexController::class, 'profile'])->name('profile');
    Route::get('/profile/edit', [IndexController::class, 'profile_edit'])->name('profile.edit');
    Route::post('/profile/update', [IndexController::class, 'profile_update'])->name('profile.update');
});
