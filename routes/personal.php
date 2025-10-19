<?php

use App\Http\Controllers\Admin\Personal\IndexController as AdminPersonalIndexController;
use App\Http\Controllers\Admin\Personal\IngredientController as AdminPersonalIngredientController;
use App\Http\Controllers\Admin\Personal\ReadingController as AdminPersonalReadingController;
use App\Http\Controllers\Admin\Personal\RecipeController as AdminPersonalRecipeController;
use App\Http\Controllers\Admin\Personal\RecipeIngredientController as AdminPersonalRecipeIngredientController;
use App\Http\Controllers\Admin\Personal\RecipeStepController as AdminPersonalRecipeStepController;
use App\Http\Controllers\Admin\Personal\UnitController as AdminPortfolioUnitController;
use App\Http\Controllers\Guest\Personal\IndexController as GuestPersonalIndexController;
use App\Http\Controllers\Guest\Personal\ReadingController as GuestPersonalReadingController;
use App\Http\Controllers\Guest\Personal\RecipeController as GuestPersonalRecipeController;
use Illuminate\Support\Facades\Route;

Route::name('guest.')->middleware('guest')->group(function () {

    // resources
    Route::prefix('personal')->name('personal.')->group(function () {
        Route::get('/', [GuestPersonalIndexController::class, 'index'])->name('index');
    });
});

Route::name('guest.')->group(function () {

     Route::get('/{admin:username}/personal', [GuestPersonalIndexController::class, 'index'])->name('user.personal.index');

    Route::get('/{admin:username}/personal/reading', [GuestPersonalReadingController::class, 'index'])->name('user.personal.reading.index');
    Route::get('/{admin:username}/personal/reading/{slug}', [GuestPersonalReadingController::class, 'show'])->name('user.personal.reading.show');

    Route::get('/{admin:username}/personal/recipe', [GuestPersonalRecipeController::class, 'index'])->name('user.personal.recipe.index');
    Route::get('/{admin:username}/personal/recipe/{slug}', [GuestPersonalRecipeController::class, 'show'])->name('user.personal.recipe.show');
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
