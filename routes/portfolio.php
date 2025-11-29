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
use Illuminate\Support\Facades\Route;

Route::prefix('admin/portfolio')->middleware('admin')->name('admin.portfolio.')->group(function () {
    Route::get('/', [AdminPortfolioIndexController::class, 'index'])->name('index');
    Route::resource('academy', AdminPortfolioAcademyController::class);
    Route::resource('art', AdminPortfolioArtController::class);
    Route::resource('audio', AdminPortfolioAudioController::class);
    Route::resource('award', AdminPortfolioAwardController::class);
    Route::resource('certificate', AdminPortfolioCertificateController::class);
    Route::resource('certification', AdminPortfolioCertificationController::class);
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
    Route::resource('school', AdminPortfolioSchoolController::class);
    Route::resource('skill', AdminPortfolioSkillController::class);
    Route::resource('video', AdminPortfolioVideoController::class);
});

Route::name('guest.')->middleware('guest')->group(function () {

});

