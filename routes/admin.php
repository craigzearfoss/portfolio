<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\ApplicationController;
use App\Http\Controllers\Admin\CertificateController;
use App\Http\Controllers\Admin\CommunicationController;
use App\Http\Controllers\Admin\CompanyController;
use App\Http\Controllers\Admin\ContactController;
use App\Http\Controllers\Admin\CoverLetterController;
use App\Http\Controllers\Admin\IndexController;
use App\Http\Controllers\Admin\JobBoardController;
use App\Http\Controllers\Admin\LinkController;
use App\Http\Controllers\Admin\NoteController;
use App\Http\Controllers\Admin\ProjectController;
use App\Http\Controllers\Admin\ReadingController;
use App\Http\Controllers\Admin\ResumeController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\VideoController;

use Illuminate\Support\Facades\Route;

Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [IndexController::class, 'index'])->name('index');
    Route::get('/login', [IndexController::class, 'login'])->name('login');
    Route::post('/login', [IndexController::class, 'login'])->name('login_submit');
    Route::get('/logout', [IndexController::class, 'logout'])->name('logout');
    Route::get('/forgot-password', [IndexController::class, 'forgot_password'])->name('forgot_password');
    Route::post('/forgot-password', [IndexController::class, 'forgot_password'])->name('forgot_password_submit');
    Route::get('/reset-password/{token}/{email}', [IndexController::class, 'reset_password'])->name('reset_password');
    Route::post('/reset-password/{token}/{email}', [IndexController::class, 'reset_password_submit'])->name('reset_password_submit');
});

Route::prefix('admin')->middleware('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [IndexController::class, 'dashboard'])->name('dashboard');
    Route::resource('admin', AdminController::class);
    Route::resource('application', ApplicationController::class);
    Route::resource('certificate', CertificateController::class);
    Route::resource('communication', CommunicationController::class);
    Route::resource('company', CompanyController::class);
    Route::resource('contact', ContactController::class);
    Route::resource('cover-letter', CoverLetterController::class);
    Route::resource('job-board', JobBoardController::class);
    Route::resource('link', LinkController::class);
    Route::resource('note', NoteController::class);
    Route::get('/profile', [IndexController::class, 'profile'])->name('profile');
    Route::get('/profile/edit', [IndexController::class, 'profile_edit'])->name('profile.edit');
    Route::post('/profile/update', [IndexController::class, 'profile_update'])->name('profile.update');
    Route::resource('project', ProjectController::class);
    Route::resource('reading', ReadingController::class);
    Route::resource('resume', ResumeController::class);
    Route::resource('user', UserController::class);
    Route::resource('video', VideoController::class);
});
