<?php

use App\Http\Controllers\Admin\Personal\IndexController as AdminPersonalIndexController;
use App\Http\Controllers\Admin\Personal\IngredientController as AdminPersonalIngredientController;
use App\Http\Controllers\Admin\Personal\ReadingController as AdminPersonalReadingController;
use App\Http\Controllers\Admin\Personal\RecipeController as AdminPersonalRecipeController;
use App\Http\Controllers\Admin\Personal\RecipeIngredientController as AdminPersonalRecipeIngredientController;
use App\Http\Controllers\Admin\Personal\RecipeStepController as AdminPersonalRecipeStepController;
use App\Http\Controllers\Admin\Personal\UnitController as AdminPortfolioUnitController;
use App\Http\Controllers\Guest\Personal\IndexController as GuestPersonalIndexController;
use Illuminate\Support\Facades\Route;

Route::get('personal', [GuestPersonalIndexController::class, 'index'])->name('guest.personal.index');

Route::prefix('admin/personal')->middleware('admin')->name('admin.personal.')->group(function () {
    Route::get('/', [AdminPersonalIndexController::class, 'index'])->name('index');
    Route::resource('ingredient', AdminPersonalIngredientController::class);
    Route::resource('reading', AdminPersonalReadingController::class);
    Route::resource('recipe', AdminPersonalRecipeController::class);
    Route::resource('recipe-ingredient', AdminPersonalRecipeIngredientController::class)->parameter('recipe-ingredient', 'recipe_ingredient');
    Route::resource('recipe-step', AdminPersonalRecipeStepController::class)->parameter('recipe-step', 'recipe_step');
    Route::resource('unit', AdminPortfolioUnitController::class);
});
