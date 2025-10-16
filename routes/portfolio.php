<?php

use App\Http\Controllers\Admin\Portfolio\AcademyController as AdminPortfolioAcademyController;
use App\Http\Controllers\Admin\Portfolio\ArtController as AdminPortfolioArtController;
use App\Http\Controllers\Admin\Portfolio\AudioController as AdminPortfolioAudioController;
use App\Http\Controllers\Admin\Portfolio\CertificationController as AdminPortfolioCertificationController;
use App\Http\Controllers\Admin\Portfolio\CourseController as AdminPortfolioCourseController;
use App\Http\Controllers\Admin\Portfolio\IndexController as AdminPortfolioIndexController;
use App\Http\Controllers\Admin\Portfolio\JobController as AdminPortfolioJobController;
use App\Http\Controllers\Admin\Portfolio\JobCoworkerController as AdminPortfolioJobCoworkerController;
use App\Http\Controllers\Admin\Portfolio\JobTaskController as AdminPortfolioJobTaskController;
use App\Http\Controllers\Admin\Portfolio\JobSkillController as AdminPortfolioJobSkillController;
use App\Http\Controllers\Admin\Portfolio\LinkController as AdminPortfolioLinkController;
use App\Http\Controllers\Admin\Portfolio\MusicController as AdminPortfolioMusicController;
use App\Http\Controllers\Admin\Portfolio\ProjectController as AdminPortfolioProjectController;
use App\Http\Controllers\Admin\Portfolio\PublicationController as AdminPortfolioPublicationController;
use App\Http\Controllers\Admin\Portfolio\SkillController as AdminPortfolioSkillController;
use App\Http\Controllers\Admin\Portfolio\VideoController as AdminPortfolioVideoController;
use App\Http\Controllers\Guest\Portfolio\ArtController as GuestPortfolioArtController;
use App\Http\Controllers\Guest\Portfolio\AudioController as GuestPortfolioAudioController;
use App\Http\Controllers\Guest\Portfolio\CertificationController as GuestPortfolioCertificationController;
use App\Http\Controllers\Guest\Portfolio\CourseController as GuestPortfolioCourseController;
use App\Http\Controllers\Guest\Portfolio\JobController as GuestPortfolioJobController;
use App\Http\Controllers\Guest\Portfolio\LinkController as GuestPortfolioLinkController;
use App\Http\Controllers\Guest\Portfolio\MusicController as GuestPortfolioMusicController;
use App\Http\Controllers\Guest\Portfolio\IndexController as GuestPortfolioIndexController;
use App\Http\Controllers\Guest\Portfolio\ProjectController as GuestPortfolioProjectController;
use App\Http\Controllers\Guest\Portfolio\PublicationController as GuestPortfolioPublicationController;
use App\Http\Controllers\Guest\Portfolio\SkillController as GuestPortfolioSkillController;
use App\Http\Controllers\Guest\Portfolio\VideoController as GuestPortfolioVideoController;
use Illuminate\Support\Facades\Route;

Route::name('guest.')->group(function () {

    Route::get('/resume', [GuestPortfolioJobController::class, 'resume'])->name('resume');

    // resources
    Route::prefix('portfolio')->name('portfolio.')->group(function () {
        Route::get('/', [GuestPortfolioIndexController::class, 'index'])->name('index');
        Route::get('/art', [GuestPortfolioArtController::class, 'index'])->name('art.index');
        Route::get('/art/{slug}', [GuestPortfolioArtController::class, 'show'])->name('art.show');
        Route::get('/audio', [GuestPortfolioAudioController::class, 'index'])->name('audio.index');
        Route::get('/audio/{slug}', [GuestPortfolioAudioController::class, 'show'])->name('audio.show');
        Route::get('/certification', [GuestPortfolioCertificationController::class, 'index'])->name('certification.index');
        Route::get('/certification/{slug}', [GuestPortfolioCertificationController::class, 'show'])->name('certification.show');
        Route::get('/course', [GuestPortfolioCourseController::class, 'index'])->name('course.index');
        Route::get('/course/{slug}', [GuestPortfolioCourseController::class, 'show'])->name('course.show');
        Route::get('/link', [GuestPortfolioLinkController::class, 'index'])->name('link.index');
        Route::get('/link/{slug}', [GuestPortfolioLinkController::class, 'show'])->name('link.show');
        Route::get('/music', [GuestPortfolioMusicController::class, 'index'])->name('music.index');
        Route::get('/music/{slug}', [GuestPortfolioMusicController::class, 'show'])->name('music.show');
        Route::get('/project', [GuestPortfolioProjectController::class, 'index'])->name('project.index');
        Route::get('/project/{slug}', [GuestPortfolioProjectController::class, 'show'])->name('project.show');
        Route::get('/publication', [GuestPortfolioPublicationController::class, 'index'])->name('publication.index');
        Route::get('/publication/{slug}', [GuestPortfolioPublicationController::class, 'show'])->name('publication.show');
        Route::get('/skill', [GuestPortfolioSkillController::class, 'index'])->name('skill.index');
        Route::get('/skill/{slug}', [GuestPortfolioSkillController::class, 'show'])->name('skill.show');
        Route::get('/video', [GuestPortfolioVideoController::class, 'index'])->name('video.index');
        Route::get('/video/{slug}', [GuestPortfolioVideoController::class, 'show'])->name('video.show');
    });
});

Route::prefix('admin/portfolio')->middleware('admin')->name('admin.portfolio.')->group(function () {
    Route::get('/', [AdminPortfolioIndexController::class, 'index'])->name('index');
    Route::resource('academy', AdminPortfolioAcademyController::class);
    Route::resource('art', AdminPortfolioArtController::class);
    Route::resource('audio', AdminPortfolioAudioController::class);
    Route::resource('certification', AdminPortfolioCertificationController::class);
    Route::resource('course', AdminPortfolioCourseController::class);
    Route::resource('job', AdminPortfolioJobController::class);
    Route::resource('job-coworker', AdminPortfolioJobCoworkerController::class);
    Route::resource('job-skill', AdminPortfolioJobSkillController::class);
    Route::resource('job-task', AdminPortfolioJobTaskController::class);
    Route::resource('link', AdminPortfolioLinkController::class);
    Route::resource('music', AdminPortfolioMusicController::class);
    Route::resource('project', AdminPortfolioProjectController::class);
    Route::resource('publication', AdminPortfolioPublicationController::class);
    Route::resource('skill', AdminPortfolioSkillController::class);
    Route::resource('video', AdminPortfolioVideoController::class);
});
