<?php

use App\Http\Controllers\Guest\Personal\IndexController as GuestPersonalIndexController;
use App\Http\Controllers\Guest\Personal\ReadingController as GuestPersonalReadingController;
use App\Http\Controllers\Guest\Personal\RecipeController as GuestPersonalRecipeController;

use App\Http\Controllers\Guest\System\AdminController as GuestAdminController;
use App\Http\Controllers\Guest\Portfolio\ArtController as GuestPortfolioArtController;
use App\Http\Controllers\Guest\Portfolio\AudioController as GuestPortfolioAudioController;
use App\Http\Controllers\Guest\Portfolio\AwardController as GuestPortfolioAwardController;
use App\Http\Controllers\Guest\Portfolio\CertificateController as GuestPortfolioCertificateController;
use App\Http\Controllers\Guest\Portfolio\CourseController as GuestPortfolioCourseController;
use App\Http\Controllers\Guest\Portfolio\EducationController as GuestPortfolioEducationController;
use App\Http\Controllers\Guest\Portfolio\LinkController as GuestPortfolioLinkController;
use App\Http\Controllers\Guest\Portfolio\MusicController as GuestPortfolioMusicController;
use App\Http\Controllers\Guest\Portfolio\IndexController as GuestPortfolioIndexController;
use App\Http\Controllers\Guest\Portfolio\PhotographyController as GuestPortfolioPhotographyController;
use App\Http\Controllers\Guest\Portfolio\ProjectController as GuestPortfolioProjectController;
use App\Http\Controllers\Guest\Portfolio\PublicationController as GuestPortfolioPublicationController;
use App\Http\Controllers\Guest\Portfolio\ResumeController as GuestPortfolioResumeController;
use App\Http\Controllers\Guest\Portfolio\SkillController as GuestPortfolioSkillController;
use App\Http\Controllers\Guest\Portfolio\VideoController as GuestPortfolioVideoController;

use Illuminate\Support\Facades\Route;

Route::get('/{admin:label}', [GuestAdminController::class, 'show'])->name('guest.admin.show');

Route::name('guest.')->middleware('guest')->group(function () {

    Route::get('/{admin:label}/personal', [GuestPersonalIndexController::class, 'index'])->name('admin.personal.show');
    Route::get('/{admin:label}/personal/reading', [GuestPersonalReadingController::class, 'index'])->name('admin.personal.reading.index');
    Route::get('/{admin:label}/personal/reading/{slug}', [GuestPersonalReadingController::class, 'show'])->name('admin.personal.reading.show');
    Route::get('/{admin:label}/personal/recipe', [GuestPersonalRecipeController::class, 'index'])->name('admin.personal.recipe.index');
    Route::get('/{admin:label}/personal/recipe/{slug}', [GuestPersonalRecipeController::class, 'show'])->name('admin.personal.recipe.show');

    Route::get('/{admin:label}/resume', [GuestPortfolioResumeController::class, 'index'])->name('admin.resume');
    Route::get('/{admin:label}/portfolio', [GuestPortfolioIndexController::class, 'index'])->name('admin.portfolio.show');
    Route::get('/{admin:label}/portfolio/art', [GuestPortfolioArtController::class, 'index'])->name('admin.portfolio.art.index');
    Route::get('/{admin:label}/portfolio/art/{slug}', [GuestPortfolioArtController::class, 'show'])->name('admin.portfolio.art.show');
    Route::get('/{admin:label}/portfolio/audio', [GuestPortfolioAudioController::class, 'index'])->name('admin.portfolio.audio.index');
    Route::get('/{admin:label}/portfolio/audio/{slug}', [GuestPortfolioAudioController::class, 'show'])->name('admin.portfolio.audio.show');

    Route::get('/{admin:label}/portfolio/award', [GuestPortfolioAwardController::class, 'index'])->name('admin.portfolio.award.index');
    Route::get('/{admin:label}/portfolio/award/{slug}', [GuestPortfolioAwardController::class, 'show'])->name('admin.portfolio.award.show');
    Route::get('/{admin:label}/portfolio/certificate', [GuestPortfolioCertificateController::class, 'index'])->name('admin.portfolio.certificate.index');
    Route::get('/{admin:label}/portfolio/certificate/{slug}', [GuestPortfolioCertificateController::class, 'show'])->name('admin.portfolio.certificate.show');
    Route::get('/{admin:label}/portfolio/course', [GuestPortfolioCourseController::class, 'index'])->name('admin.portfolio.course.index');
    Route::get('/{admin:label}/portfolio/course/{slug}', [GuestPortfolioCourseController::class, 'show'])->name('admin.portfolio.course.show');
    Route::get('/{admin:label}/portfolio/education', [GuestPortfolioEducationController::class, 'index'])->name('admin.portfolio.education.index');
    Route::get('/{admin:label}/portfolio/education/{id}', [GuestPortfolioEducationController::class, 'show'])->name('admin.portfolio.education.show');
    Route::get('/{admin:label}/portfolio/link', [GuestPortfolioLinkController::class, 'index'])->name('admin.portfolio.link.index');
    Route::get('/{admin:label}/portfolio/link/{slug}', [GuestPortfolioLinkController::class, 'show'])->name('admin.portfolio.link.show');
    Route::get('/{admin:label}/portfolio/music', [GuestPortfolioMusicController::class, 'index'])->name('admin.portfolio.music.index');
    Route::get('/{admin:label}/portfolio/music/{slug}', [GuestPortfolioMusicController::class, 'show'])->name('admin.portfolio.music.show');
    Route::get('/{admin:label}/portfolio/photography', [GuestPortfolioPhotographyController::class, 'index'])->name('admin.portfolio.photography.index');
    Route::get('/{admin:label}/portfolio/photography/{slug}', [GuestPortfolioPhotographyController::class, 'show'])->name('admin.portfolio.photography.show');
    Route::get('/{admin:label}/portfolio/project', [GuestPortfolioProjectController::class, 'index'])->name('admin.portfolio.project.index');
    Route::get('/{admin:label}/portfolio/project/{slug}', [GuestPortfolioProjectController::class, 'show'])->name('admin.portfolio.project.show');
    Route::get('/{admin:label}/portfolio/publication', [GuestPortfolioPublicationController::class, 'index'])->name('admin.portfolio.publication.index');
    Route::get('/{admin:label}/portfolio/publication/{slug}', [GuestPortfolioPublicationController::class, 'show'])->name('admin.portfolio.publication.show');
    Route::get('/{admin:label}/portfolio/skill', [GuestPortfolioSkillController::class, 'index'])->name('admin.portfolio.skill.index');
    Route::get('/{admin:label}/portfolio/skill/{slug}', [GuestPortfolioSkillController::class, 'show'])->name('admin.portfolio.skill.show');
    Route::get('/{admin:label}/portfolio/video', [GuestPortfolioVideoController::class, 'index'])->name('admin.portfolio.video.index');
    Route::get('/{admin:label}/portfolio/video/{slug}', [GuestPortfolioVideoController::class, 'show'])->name('admin.portfolio.video.show');

});
