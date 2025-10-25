<?php

use App\Http\Controllers\Guest\Personal\IndexController as GuestPersonalIndexController;
use App\Http\Controllers\Guest\Personal\ReadingController as GuestPersonalReadingController;
use App\Http\Controllers\Guest\Personal\RecipeController as GuestPersonalRecipeController;

use App\Http\Controllers\Guest\IndexController as GuestIndexController;
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

    Route::get('/{admin:username}/personal', [GuestPersonalIndexController::class, 'index'])->name('user.personal.index');
    Route::get('/{admin:username}/personal/reading', [GuestPersonalReadingController::class, 'index'])->name('user.personal.reading.index');
    Route::get('/{admin:username}/personal/reading/{slug}', [GuestPersonalReadingController::class, 'show'])->name('user.personal.reading.show');
    Route::get('/{admin:username}/personal/recipe', [GuestPersonalRecipeController::class, 'index'])->name('user.personal.recipe.index');
    Route::get('/{admin:username}/personal/recipe/{slug}', [GuestPersonalRecipeController::class, 'show'])->name('user.personal.recipe.show');

    Route::get('/{admin:username}', [GuestIndexController::class, 'index'])->name('user.index');
    Route::get('/{admin:username}', [GuestPortfolioIndexController::class, 'index'])->name('user.index');
    Route::get('/{admin:username}/resume', [GuestPortfolioJobController::class, 'resume'])->name('user.resume');
    Route::get('/{admin:username}/portfolio', [GuestPortfolioIndexController::class, 'index'])->name('user.portfolio.index');
    Route::get('/{admin}/portfolio/art', [GuestPortfolioArtController::class, 'index'])->name('user.portfolio.art.index');
    Route::get('/{admin}/portfolio/art/{slug}', [GuestPortfolioArtController::class, 'show'])->name('user.portfolio.art.show');
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
