<?php

use App\Http\Controllers\Admin\Portfolio\AcademyController as AdminPortfolioAcademyController;
use App\Http\Controllers\Admin\Portfolio\ArtController as AdminPortfolioArtController;
use App\Http\Controllers\Admin\Portfolio\AudioController as AdminPortfolioAudioController;
use App\Http\Controllers\Admin\Portfolio\AwardController as AdminPortfolioAwardController;
use App\Http\Controllers\Admin\Portfolio\CertificateController as AdminPortfolioCertificateController;
use App\Http\Controllers\Admin\Portfolio\CertificationController as AdminPortfolioCertificationController;
use App\Http\Controllers\Admin\Portfolio\CourseController as AdminPortfolioCourseController;
use App\Http\Controllers\Admin\Portfolio\EducationController as AdminPortfolioEducationController;
use App\Http\Controllers\Admin\Portfolio\IndexController as AdminPortfolioIndexController;
use App\Http\Controllers\Admin\Portfolio\JobController as AdminPortfolioJobController;
use App\Http\Controllers\Admin\Portfolio\JobCoworkerController as AdminPortfolioJobCoworkerController;
use App\Http\Controllers\Admin\Portfolio\JobTaskController as AdminPortfolioJobTaskController;
use App\Http\Controllers\Admin\Portfolio\JobSkillController as AdminPortfolioJobSkillController;
use App\Http\Controllers\Admin\Portfolio\LinkController as AdminPortfolioLinkController;
use App\Http\Controllers\Admin\Portfolio\MusicController as AdminPortfolioMusicController;
use App\Http\Controllers\Admin\Portfolio\PhotographyController as AdminPortfolioPhotographyController;
use App\Http\Controllers\Admin\Portfolio\ProjectController as AdminPortfolioProjectController;
use App\Http\Controllers\Admin\Portfolio\PublicationController as AdminPortfolioPublicationController;
use App\Http\Controllers\Admin\Portfolio\SchoolController as AdminPortfolioSchoolController;
use App\Http\Controllers\Admin\Portfolio\SkillController as AdminPortfolioSkillController;
use App\Http\Controllers\Admin\Portfolio\VideoController as AdminPortfolioVideoController;

use App\Http\Controllers\Guest\Portfolio\ArtController as GuestPortfolioArtController;
use App\Http\Controllers\Guest\Portfolio\AudioController as GuestPortfolioAudioController;
use App\Http\Controllers\Guest\Portfolio\AwardController as GuestPortfolioAwardController;
use App\Http\Controllers\Guest\Portfolio\CertificateController as GuestPortfolioCertificateController;
use App\Http\Controllers\Guest\Portfolio\CourseController as GuestPortfolioCourseController;
use App\Http\Controllers\Guest\Portfolio\EducationController as GuestPortfolioEducationController;
use App\Http\Controllers\Guest\Portfolio\JobController as GuestPortfolioJobController;
use App\Http\Controllers\Guest\Portfolio\LinkController as GuestPortfolioLinkController;
use App\Http\Controllers\Guest\Portfolio\MusicController as GuestPortfolioMusicController;
use App\Http\Controllers\Guest\Portfolio\IndexController as GuestPortfolioIndexController;
use App\Http\Controllers\Guest\Portfolio\PhotographyController as GuestPortfolioPhotographyController;
use App\Http\Controllers\Guest\Portfolio\ProjectController as GuestPortfolioProjectController;
use App\Http\Controllers\Guest\Portfolio\PublicationController as GuestPortfolioPublicationController;
use App\Http\Controllers\Guest\Portfolio\SkillController as GuestPortfolioSkillController;
use App\Http\Controllers\Guest\Portfolio\VideoController as GuestPortfolioVideoController;

use Illuminate\Support\Facades\Route;

Route::prefix('admin/portfolio')->middleware('admin')->name('admin.portfolio.')->group(function () {

    Route::get('/', [AdminPortfolioIndexController::class, 'index'])->name('index');

    Route::resource('academy', AdminPortfolioAcademyController::class);
    Route::resource('certification', AdminPortfolioCertificationController::class);
    Route::resource('school', AdminPortfolioSchoolController::class);

    Route::resource('art', AdminPortfolioArtController::class);
    Route::resource('audio', AdminPortfolioAudioController::class);
    Route::resource('award', AdminPortfolioAwardController::class);
    Route::resource('certificate', AdminPortfolioCertificateController::class);
    Route::resource('course', AdminPortfolioCourseController::class);
    Route::resource('education', AdminPortfolioEducationController::class);
    Route::resource('job', AdminPortfolioJobController::class);
    Route::resource('job-coworker', AdminPortfolioJobCoworkerController::class);
    Route::resource('job-skill', AdminPortfolioJobSkillController::class);
    Route::resource('job-task', AdminPortfolioJobTaskController::class);
    Route::resource('link', AdminPortfolioLinkController::class);
    Route::resource('music', AdminPortfolioMusicController::class);
    Route::resource('photography', AdminPortfolioPhotographyController::class);
    Route::resource('project', AdminPortfolioProjectController::class);
    Route::resource('publication', AdminPortfolioPublicationController::class);
    Route::resource('skill', AdminPortfolioSkillController::class);
    Route::resource('video', AdminPortfolioVideoController::class);
});

Route::name('guest.')->middleware('guest')->group(function () {
    Route::get('/{admin:label}/resume', [GuestPortfolioJobController::class, 'resume'])->name('resume');
    Route::get('/{admin:label}/portfolio', [GuestPortfolioIndexController::class, 'index'])->name('portfolio.index');
    Route::get('/{admin:label}/portfolio/art', [GuestPortfolioArtController::class, 'index'])->name('portfolio.art.index');
    Route::get('/{admin:label}/portfolio/art/{slug}', [GuestPortfolioArtController::class, 'show'])->name('portfolio.art.show');
    Route::get('/{admin:label}/portfolio/audio', [GuestPortfolioAudioController::class, 'index'])->name('portfolio.audio.index');
    Route::get('/{admin:label}/portfolio/audio/{slug}', [GuestPortfolioAudioController::class, 'show'])->name('portfolio.audio.show');
    Route::get('/{admin:label}/portfolio/award', [GuestPortfolioAwardController::class, 'index'])->name('portfolio.award.index');
    Route::get('/{admin:label}/portfolio/award/{slug}', [GuestPortfolioAwardController::class, 'show'])->name('portfolio.award.show');
    Route::get('/{admin:label}/portfolio/certificate', [GuestPortfolioCertificateController::class, 'index'])->name('portfolio.certificate.index');
    Route::get('/{admin:label}/portfolio/certificate/{slug}', [GuestPortfolioCertificateController::class, 'show'])->name('portfolio.certificate.show');
    Route::get('/{admin:label}/portfolio/course', [GuestPortfolioCourseController::class, 'index'])->name('portfolio.course.index');
    Route::get('/{admin:label}/portfolio/course/{slug}', [GuestPortfolioCourseController::class, 'show'])->name('portfolio.course.show');
    Route::get('/{admin:label}/portfolio/education', [GuestPortfolioEducationController::class, 'index'])->name('portfolio.education.index');
    Route::get('/{admin:label}/portfolio/job', [GuestPortfolioJobController::class, 'index'])->name('portfolio.job.index');
    Route::get('/{admin:label}/portfolio/link', [GuestPortfolioLinkController::class, 'index'])->name('portfolio.link.index');
    Route::get('/{admin:label}/portfolio/link/{slug}', [GuestPortfolioLinkController::class, 'show'])->name('portfolio.link.show');
    Route::get('/{admin:label}/portfolio/music', [GuestPortfolioMusicController::class, 'index'])->name('portfolio.music.index');
    Route::get('/{admin:label}/portfolio/music/{slug}', [GuestPortfolioMusicController::class, 'show'])->name('portfolio.music.show');
    Route::get('/{admin:label}/portfolio/photography', [GuestPortfolioPhotographyController::class, 'index'])->name('portfolio.photography.index');
    Route::get('/{admin:label}/portfolio/photography/{slug}', [GuestPortfolioPhotographyController::class, 'show'])->name('portfolio.photography.show');
    Route::get('/{admin:label}/portfolio/project', [GuestPortfolioProjectController::class, 'index'])->name('portfolio.project.index');
    Route::get('/{admin:label}/portfolio/project/{slug}', [GuestPortfolioProjectController::class, 'show'])->name('portfolio.project.show');
    Route::get('/{admin:label}/portfolio/publication', [GuestPortfolioPublicationController::class, 'index'])->name('portfolio.publication.index');
    Route::get('/{admin:label}/portfolio/publication/{slug}', [GuestPortfolioPublicationController::class, 'show'])->name('portfolio.publication.show');
    Route::get('/{admin:label}/portfolio/skill', [GuestPortfolioSkillController::class, 'index'])->name('portfolio.skill.index');
    Route::get('/{admin:label}/portfolio/video', [GuestPortfolioVideoController::class, 'index'])->name('portfolio.video.index');
    Route::get('/{admin:label}/portfolio/video/{slug}', [GuestPortfolioVideoController::class, 'show'])->name('portfolio.video.show');
});
