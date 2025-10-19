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

Route::name('guest.')->middleware('guest')->group(function () {

    Route::get('/{admin:username}', [GuestPortfolioIndexController::class, 'index'])->name('user.index');

    Route::get('/{admin:username}/resume', [GuestPortfolioJobController::class, 'resume'])->name('user.resume');

    Route::get('/{admin:username}/portfolio', [GuestPortfolioIndexController::class, 'index'])->name('user.portfolio.index');

    Route::get('/{admin:username}/portfolio/art', [GuestPortfolioArtController::class, 'index'])->name('user.portfolio.art.index');
    Route::get('/{admin:username}/portfolio/art/{slug}', [GuestPortfolioArtController::class, 'show'])->name('user.portfolio.art.show');

    Route::get('/{admin:username}/portfolio/audio', [GuestPortfolioAudioController::class, 'index'])->name('user.portfolio.audio.index');
    Route::get('/{admin:username}/portfolio/audio/{slug}', [GuestPortfolioAudioController::class, 'show'])->name('user.portfolio.audio.show');

    Route::get('/{admin:username}/portfolio/certification', [GuestPortfolioCertificationController::class, 'index'])->name('user.portfolio.certification.index');
    Route::get('/{admin:username}/portfolio/certification/{slug}', [GuestPortfolioCertificationController::class, 'show'])->name('user.portfolio.certification.show');

    Route::get('/{admin:username}/portfolio/course', [GuestPortfolioCourseController::class, 'index'])->name('user.portfolio.course.index');
    Route::get('/{admin:username}/portfolio/course/{slug}', [GuestPortfolioCourseController::class, 'show'])->name('user.portfolio.course.show');

    Route::get('/{admin:username}/portfolio/link', [GuestPortfolioLinkController::class, 'index'])->name('user.portfolio.link.index');
    Route::get('/{admin:username}/portfolio/link/{slug}', [GuestPortfolioLinkController::class, 'show'])->name('user.portfolio.link.show');

    Route::get('/{admin:username}/portfolio/music', [GuestPortfolioMusicController::class, 'index'])->name('user.portfolio.music.index');
    Route::get('/{admin:username}/portfolio/music/{slug}', [GuestPortfolioMusicController::class, 'show'])->name('user.portfolio.music.show');

    Route::get('/{admin:username}/portfolio/project', [GuestPortfolioProjectController::class, 'index'])->name('user.portfolio.project.index');
    Route::get('/{admin:username}/portfolio/project/{slug}', [GuestPortfolioProjectController::class, 'show'])->name('user.portfolio.project.show');

    Route::get('/{admin:username}/portfolio/publication', [GuestPortfolioPublicationController::class, 'index'])->name('user.portfolio.publication.index');
    Route::get('/{admin:username}portfolio//publication/{slug}', [GuestPortfolioPublicationController::class, 'show'])->name('user.portfolio.publication.show');

    Route::get('/{admin:username}/portfolio/skill', [GuestPortfolioSkillController::class, 'index'])->name('user.portfolio.skill.index');
    Route::get('/{admin:username}/portfolio/skill/{slug}', [GuestPortfolioSkillController::class, 'show'])->name('user.portfolio.skill.show');

    Route::get('/{admin:username}/portfolio/video', [GuestPortfolioVideoController::class, 'index'])->name('user.portfolio.video.index');
    Route::get('/{admin:username}/portfolio/video/{slug}', [GuestPortfolioVideoController::class, 'show'])->name('user.portfolio.video.show');
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
