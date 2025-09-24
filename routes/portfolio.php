<?php

use App\Http\Controllers\Admin\Portfolio\AcademyController as AdminPortfolioAcademyController;
use App\Http\Controllers\Admin\Portfolio\ArtController as AdminPortfolioArtController;
use App\Http\Controllers\Admin\Portfolio\CertificationController as AdminPortfolioCertificationController;
use App\Http\Controllers\Admin\Portfolio\CourseController as AdminPortfolioCourseController;
use App\Http\Controllers\Admin\Portfolio\IndexController as AdminPortfolioIndexController;
use App\Http\Controllers\Admin\Portfolio\IngredientController as AdminPortfolioIngredientController;
use App\Http\Controllers\Admin\Portfolio\LinkController as AdminPortfolioLinkController;
use App\Http\Controllers\Admin\Portfolio\MusicController as AdminPortfolioMusicController;
use App\Http\Controllers\Admin\Portfolio\ProjectController as AdminPortfolioProjectController;
use App\Http\Controllers\Admin\Portfolio\ReadingController as AdminPortfolioReadingController;
use App\Http\Controllers\Admin\Portfolio\RecipeController as AdminPortfolioRecipeController;
use App\Http\Controllers\Admin\Portfolio\RecipeIngredientController as AdminPortfolioRecipeIngredientController;
use App\Http\Controllers\Admin\Portfolio\RecipeStepController as AdminPortfolioRecipeStepController;
use App\Http\Controllers\Admin\Portfolio\UnitController as AdminPortfolioUnitController;
use App\Http\Controllers\Admin\Portfolio\VideoController as AdminPortfolioVideoController;

use App\Http\Controllers\Front\ArtController as FrontArtController;
use App\Http\Controllers\Front\CertificationController as FrontCertificationController;
use App\Http\Controllers\Front\CourseController as FrontCourseController;
use App\Http\Controllers\Front\PortfolioController as FrontPortfolioController;
use App\Http\Controllers\Front\LinkController as FrontLinkController;
use App\Http\Controllers\Front\MusicController as FrontMusicController;
use App\Http\Controllers\Front\ProjectController as FrontProjectController;
use App\Http\Controllers\Front\ReadingController as FrontReadingController;
use App\Http\Controllers\Front\RecipeController as FrontRecipeController;
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
        Route::get('/readings', [FrontReadingController::class, 'index'])->name('reading.index');
        Route::get('/reading/{slug}', [FrontReadingController::class, 'show'])->name('reading.show');
        Route::get('/recipes', [FrontRecipeController::class, 'index'])->name('recipe.index');
        Route::get('/recipe/{slug}', [FrontRecipeController::class, 'show'])->name('recipe.show');
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
    Route::resource('ingredient', AdminPortfolioIngredientController::class);
    Route::resource('link', AdminPortfolioLinkController::class);
    Route::resource('music', AdminPortfolioMusicController::class);
    Route::resource('project', AdminPortfolioProjectController::class);
    Route::resource('reading', AdminPortfolioReadingController::class);
    Route::resource('recipe', AdminPortfolioRecipeController::class);
    Route::resource('recipe-ingredient', AdminPortfolioRecipeIngredientController::class)->parameter('recipe-ingredient', 'recipe_ingredient');
    Route::resource('recipe-step', AdminPortfolioRecipeStepController::class)->parameter('recipe-step', 'recipe_step');
    Route::resource('unit', AdminPortfolioUnitController::class);
    Route::resource('video', AdminPortfolioVideoController::class);
});
