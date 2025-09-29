<?php

use App\Http\Controllers\Admin\Personal\IndexController as AdminPersonalIndexController;
use App\Http\Controllers\Admin\Personal\IngredientController as AdminPersonalIngredientController;
use App\Http\Controllers\Admin\Personal\ReadingController as AdminPersonalReadingController;
use App\Http\Controllers\Admin\Personal\RecipeController as AdminPersonalRecipeController;
use App\Http\Controllers\Admin\Personal\RecipeIngredientController as AdminPersonalRecipeIngredientController;
use App\Http\Controllers\Admin\Personal\RecipeStepController as AdminPersonalRecipeStepController;
use App\Http\Controllers\Admin\Personal\UnitController as AdminPortfolioUnitController;
use App\Http\Controllers\Front\PersonalController as FrontPersonalController;
use App\Http\Controllers\Front\ReadingController as FrontReadingController;
use App\Http\Controllers\Front\RecipeController as FrontRecipeController;
use Illuminate\Support\Facades\Route;

Route::name('front.')->group(function () {

    // resources
    Route::prefix('personal')->name('personal.')->group(function () {
        Route::get('/', [FrontPersonalController::class, 'index'])->name('index');
        Route::get('/reading', [FrontReadingController::class, 'index'])->name('reading.index');
        Route::get('/reading/{slug}', [FrontReadingController::class, 'show'])->name('reading.show');
        Route::get('/recipe', [FrontRecipeController::class, 'index'])->name('recipe.index');
        Route::get('/recipe/{slug}', [FrontRecipeController::class, 'show'])->name('recipe.show');
    });
});

Route::prefix('admin/personal')->middleware('admin')->name('admin.personal.')->group(function () {
    Route::get('/', [AdminPersonalIndexController::class, 'index'])->name('index');
    Route::resource('ingredient', AdminPersonalIngredientController::class);
    Route::resource('reading', AdminPersonalReadingController::class);
    Route::resource('recipe', AdminPersonalRecipeController::class);
    Route::resource('recipe-ingredient', AdminPersonalRecipeIngredientController::class)->parameter('recipe-ingredient', 'recipe_ingredient');
    Route::resource('recipe-step', AdminPersonalRecipeStepController::class)->parameter('recipe-step', 'recipe_step');
    Route::resource('unit', AdminPortfolioUnitController::class);
});
