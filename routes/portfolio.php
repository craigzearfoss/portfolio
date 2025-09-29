<?php

use App\Http\Controllers\Admin\Portfolio\AcademyController as AdminPortfolioAcademyController;
use App\Http\Controllers\Admin\Portfolio\ArtController as AdminPortfolioArtController;
use App\Http\Controllers\Admin\Portfolio\CertificationController as AdminPortfolioCertificationController;
use App\Http\Controllers\Admin\Portfolio\CourseController as AdminPortfolioCourseController;
use App\Http\Controllers\Admin\Portfolio\IndexController as AdminPortfolioIndexController;
use App\Http\Controllers\Admin\Portfolio\JobController as AdminPortfolioJobController;
use App\Http\Controllers\Admin\Portfolio\JobCoworkerController as AdminPortfolioJobCoworkerController;
use App\Http\Controllers\Admin\Portfolio\JobTaskController as AdminPortfolioJobTaskController;
use App\Http\Controllers\Admin\Portfolio\LinkController as AdminPortfolioLinkController;
use App\Http\Controllers\Admin\Portfolio\MusicController as AdminPortfolioMusicController;
use App\Http\Controllers\Admin\Portfolio\ProjectController as AdminPortfolioProjectController;
use App\Http\Controllers\Admin\Portfolio\VideoController as AdminPortfolioVideoController;
use App\Http\Controllers\Front\ArtController as FrontArtController;
use App\Http\Controllers\Front\CertificationController as FrontCertificationController;
use App\Http\Controllers\Front\CourseController as FrontCourseController;
use App\Http\Controllers\Front\LinkController as FrontLinkController;
use App\Http\Controllers\Front\MusicController as FrontMusicController;
use App\Http\Controllers\Front\PortfolioController as FrontPortfolioController;
use App\Http\Controllers\Front\ProjectController as FrontProjectController;
use App\Http\Controllers\Front\VideoController as FrontVideoController;
use Illuminate\Support\Facades\Route;

Route::name('front.')->group(function () {

    // resources
    Route::prefix('portfolio')->name('portfolio.')->group(function () {
        Route::get('/', [FrontPortfolioController::class, 'index'])->name('index');
        Route::get('/art', [FrontArtController::class, 'index'])->name('art.index');
        Route::get('/art/{slug}', [FrontArtController::class, 'show'])->name('art.show');
        Route::get('/certifications', [FrontCertificationController::class, 'index'])->name('certification.index');
        Route::get('/certification/{slug}', [FrontCertificationController::class, 'show'])->name('certification.show');
        Route::get('/courses', [FrontCourseController::class, 'index'])->name('course.index');
        Route::get('/course/{slug}', [FrontCourseController::class, 'show'])->name('course.show');
        Route::get('/links', [FrontLinkController::class, 'index'])->name('link.index');
        Route::get('/link/{slug}', [FrontLinkController::class, 'show'])->name('link.show');
        Route::get('/music', [FrontMusicController::class, 'index'])->name('music.index');
        Route::get('/music/{slug}', [FrontMusicController::class, 'show'])->name('music.show');
        Route::get('/projects', [FrontProjectController::class, 'index'])->name('project.index');
        Route::get('/project/{slug}', [FrontProjectController::class, 'show'])->name('project.show');
        Route::get('/videos', [FrontVideoController::class, 'index'])->name('video.index');
        Route::get('/video/{slug}', [FrontVideoController::class, 'show'])->name('video.show');
    });
});

Route::prefix('admin/portfolio')->middleware('admin')->name('admin.portfolio.')->group(function () {
    Route::get('/', [AdminPortfolioIndexController::class, 'index'])->name('index');
    Route::resource('academy', AdminPortfolioAcademyController::class);
    Route::resource('art', AdminPortfolioArtController::class);
    Route::resource('certification', AdminPortfolioCertificationController::class);
    Route::resource('course', AdminPortfolioCourseController::class);
    Route::resource('job', AdminPortfolioJobController::class);
    Route::resource('job-coworkers', AdminPortfolioJobCoworkerController::class);
    Route::resource('job-tasks', AdminPortfolioJobTaskController::class);
    Route::resource('link', AdminPortfolioLinkController::class);
    Route::resource('music', AdminPortfolioMusicController::class);
    Route::resource('project', AdminPortfolioProjectController::class);
    Route::resource('video', AdminPortfolioVideoController::class);
});
