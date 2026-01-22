<?php

use App\Http\Controllers\Admin\Personal\IndexController as AdminPersonalIndexController;
use App\Http\Controllers\Admin\Personal\IngredientController as AdminPersonalIngredientController;
use App\Http\Controllers\Admin\Personal\ReadingController as AdminPersonalReadingController;
use App\Http\Controllers\Admin\Personal\RecipeController as AdminPersonalRecipeController;
use App\Http\Controllers\Admin\Personal\RecipeIngredientController as AdminPersonalRecipeIngredientController;
use App\Http\Controllers\Admin\Personal\RecipeStepController as AdminPersonalRecipeStepController;
use App\Http\Controllers\Admin\Personal\UnitController as AdminPersonalUnitController;
use App\Http\Controllers\Root\Personal\IndexController as RootPersonalIndexController;
use App\Http\Controllers\Root\Personal\IngredientController as RootPersonalIngredientController;
use App\Http\Controllers\Root\Personal\ReadingController as RootPersonalReadingController;
use App\Http\Controllers\Root\Personal\RecipeController as RootPersonalRecipeController;
use App\Http\Controllers\Root\Personal\RecipeIngredientController as RootPersonalRecipeIngredientController;
use App\Http\Controllers\Root\Personal\RecipeStepController as RootPersonalRecipeStepController;
use App\Http\Controllers\Root\Personal\UnitController as RootPersonalUnitController;
use App\Http\Controllers\Guest\Personal\IndexController as GuestPersonalIndexController;
use App\Http\Controllers\Guest\Personal\ReadingController as GuestPersonalReadingController;
use App\Http\Controllers\Guest\Personal\RecipeController as GuestPersonalRecipeController;
use Illuminate\Support\Facades\Route;

Route::prefix('admin/personal')->middleware('admin')->name('admin.personal.')->group(function () {

    Route::get('/', [AdminPersonalIndexController::class, 'index'])->name('index');

    Route::resource('personal/ingredient', AdminPersonalIngredientController::class);
    Route::resource('personal/unit', AdminPersonalUnitController::class);

    Route::resource('reading', AdminPersonalReadingController::class);
    Route::resource('recipe', AdminPersonalRecipeController::class);
    Route::resource('recipe', AdminPersonalRecipeController::class);
    Route::resource('recipe-ingredient', AdminPersonalRecipeIngredientController::class)->parameter('recipe-ingredient', 'recipe_ingredient');
    Route::resource('recipe-step', AdminPersonalRecipeStepController::class)->parameter('recipe-step', 'recipe_step');
});

Route::name('guest.')->middleware('guest')->group(function () {
    Route::get('/{admin:label}/personal', [GuestPersonalIndexController::class, 'index'])->name('personal.index');
    Route::get('/{admin:label}/personal/reading', [GuestPersonalReadingController::class, 'index'])->name('personal.reading.index');
    Route::get('/{admin:label}/personal/reading/{slug}', [GuestPersonalReadingController::class, 'show'])->name('personal.reading.show');
    Route::get('/{admin:label}/personal/recipe', [GuestPersonalRecipeController::class, 'index'])->name('personal.recipe.index');
    Route::get('/{admin:label}/personal/recipe/{slug}', [GuestPersonalRecipeController::class, 'show'])->name('personal.recipe.show');
});
