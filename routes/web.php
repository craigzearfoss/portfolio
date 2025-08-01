<?php

use App\Http\Controllers\Admin\AdminController as AdminAdminController;
use App\Http\Controllers\Admin\ApplicationController as AdminApplicationController;
use App\Http\Controllers\Admin\CertificateController as AdminCertificateController;
use App\Http\Controllers\Admin\CommunicationController as AdminCommunicationController;
use App\Http\Controllers\Admin\CompanyController as AdminCompanyController;
use App\Http\Controllers\Admin\ContactController as AdminContactController;
use App\Http\Controllers\Admin\CoverLetterController as AdminCoverLetterController;
use App\Http\Controllers\Admin\IndexController as AdminIndexController;
use App\Http\Controllers\Admin\LinkController as AdminLinkController;
use App\Http\Controllers\Admin\NoteController as AdminNoteController;
use App\Http\Controllers\Admin\ProjectController as AdminProjectController;
use App\Http\Controllers\Admin\ReadingController as AdminReadingController;
use App\Http\Controllers\Admin\ResumeController as AdminResumeController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\VideoController as AdminVideoController;
use App\Http\Controllers\Front\FrontendController;
use App\Http\Controllers\Front\CertificateController as FrontCertificateController;
use App\Http\Controllers\Front\LinkController as FrontLinkController;
use App\Http\Controllers\Front\ProjectController as FrontProjectController;
use App\Http\Controllers\Front\ReadingController as FrontReadingController;
use App\Http\Controllers\Front\VideoController as FrontVideoController;
use App\Http\Controllers\User\UserController;
use Illuminate\Support\Facades\Route;

// Frontend
Route::get('/', [FrontendController::class, 'index'])->name('homepage');
Route::get('/certificate', [FrontCertificateController::class, 'index'])->name('certificate.index');
Route::get('/link', [FrontLinkController::class, 'index'])->name('link.index');
Route::get('/project', [FrontProjectController::class, 'index'])->name('project.index');
Route::get('/reading', [FrontReadingController::class, 'index'])->name('reading.index');
Route::get('/video', [FrontVideoController::class, 'index'])->name('video.index');

// Admin
Route::prefix('admin')->middleware('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminIndexController::class, 'dashboard'])->name('dashboard');
    Route::resource('admin', AdminAdminController::class);
    Route::resource('application', AdminApplicationController::class);
    Route::resource('certificate', AdminCertificateController::class);
    Route::resource('communication', AdminCommunicationController::class);
    Route::resource('company', AdminCompanyController::class);
    Route::resource('contact', AdminContactController::class);
    Route::resource('cover-letter', AdminCoverLetterController::class);
    Route::resource('link', AdminLinkController::class);
    Route::resource('note', AdminNoteController::class);
    Route::resource('project', AdminProjectController::class);
    Route::resource('reading', AdminReadingController::class);
    Route::resource('resume', AdminResumeController::class);
    Route::resource('user', AdminUserController::class);
    Route::resource('video', AdminVideoController::class);
});

Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [AdminIndexController::class, 'index'])->name('index');
    Route::get('/login', [AdminIndexController::class, 'login'])->name('login');
    Route::post('/login', [AdminIndexController::class, 'login'])->name('login_submit');
    Route::get('/logout', [AdminIndexController::class, 'logout'])->name('logout');
    Route::get('/forgot-password', [AdminIndexController::class, 'forgot_password'])->name('forgot_password');
    Route::post('/forgot-password', [AdminIndexController::class, 'forgot_password'])->name('forgot_password_submit');
    Route::get('/reset-password/{token}/{email}', [AdminIndexController::class, 'reset_password'])->name('reset_password');
    Route::post('/reset-password/{token}/{email}', [AdminIndexController::class, 'reset_password_submit'])->name('reset_password_submit');
});

// User
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [UserController::class, 'dashboard'])->name('dashboard');
});

Route::get('/register', [UserController::class, 'register'])->name('register');
Route::post('/register', [UserController::class, 'register'])->name('register_submit');
Route::get('/verify-email/{token}/{email}', [UserController::class, 'email_verification'])->name('email_verification');
Route::get('/login', [UserController::class, 'login'])->name('login');
Route::post('/login', [UserController::class, 'login'])->name('login_submit');
Route::get('/logout', [UserController::class, 'logout'])->name('logout');
Route::get('/forgot-password', [UserController::class, 'forgot_password'])->name('forgot_password');
Route::post('/forgot-password', [UserController::class, 'forgot_password'])->name('forgot_password_submit');
Route::get('/reset-password/{token}/{email}', [UserController::class, 'reset_password'])->name('reset_password');
Route::post('/reset-password/{token}/{email}', [UserController::class, 'reset_password_submit'])->name('reset_password_submit');
