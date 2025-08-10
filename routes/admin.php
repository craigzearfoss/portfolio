<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\CareerApplicationController;
use App\Http\Controllers\Admin\CareerCommunicationController;
use App\Http\Controllers\Admin\CareerCompanyController;
use App\Http\Controllers\Admin\CareerContactController;
use App\Http\Controllers\Admin\CareerCoverLetterController;
use App\Http\Controllers\Admin\CareerJobBoardController;
use App\Http\Controllers\Admin\CareerJobController;
use App\Http\Controllers\Admin\CareerNoteController;
use App\Http\Controllers\Admin\CareerReferenceController;
use App\Http\Controllers\Admin\CareerResumeController;
use App\Http\Controllers\Admin\CareerSkillController;
use App\Http\Controllers\Admin\IndexController;
use App\Http\Controllers\Admin\PortfolioArtController;
use App\Http\Controllers\Admin\PortfolioCertificationController;
use App\Http\Controllers\Admin\PortfolioCourseController;
use App\Http\Controllers\Admin\PortfolioLinkController;
use App\Http\Controllers\Admin\PortfolioMusicController;
use App\Http\Controllers\Admin\PortfolioProjectController;
use App\Http\Controllers\Admin\PortfolioReadingController;
use App\Http\Controllers\Admin\PortfolioRecipeController;
use App\Http\Controllers\Admin\PortfolioVideoController;
use App\Http\Controllers\Admin\ResourceController;
use App\Http\Controllers\Admin\UserController;

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
    Route::resource('application', CareerApplicationController::class);
    Route::resource('art', PortfolioArtController::class);
    Route::resource('certification', PortfolioCertificationController::class);
    Route::resource('communication', CareerCommunicationController::class);
    Route::resource('company', CareerCompanyController::class);
    Route::resource('contact', CareerContactController::class);
    Route::resource('course', PortfolioCourseController::class);
    Route::resource('cover_letter', CareerCoverLetterController::class);
    Route::resource('job', CareerJobController::class);
    Route::resource('job_board', CareerJobBoardController::class);
    Route::resource('link', PortfolioLinkController::class);
    Route::resource('music', PortfolioMusicController::class);
    Route::resource('note', CareerNoteController::class);
    Route::get('/profile', [IndexController::class, 'profile'])->name('profile');
    Route::get('/profile/edit', [IndexController::class, 'profile_edit'])->name('profile.edit');
    Route::post('/profile/update', [IndexController::class, 'profile_update'])->name('profile.update');
    Route::resource('project', PortfolioProjectController::class);
    Route::resource('reading', PortfolioReadingController::class);
    Route::resource('recipe', PortfolioRecipeController::class);
    Route::resource('reference', CareerReferenceController::class);
    Route::resource('resource', ResourceController::class);
    Route::resource('resume', CareerResumeController::class);
    Route::resource('skill', CareerSkillController::class);
    Route::resource('user', UserController::class);
    Route::resource('video', PortfolioVideoController::class);
});
