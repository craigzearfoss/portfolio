<?php

use App\Http\Controllers\Admin\Personal\IndexController as AdminPersonalIndexController;
use App\Http\Controllers\Admin\Personal\IngredientController as AdminPersonalIngredientController;
use App\Http\Controllers\Admin\Personal\ReadingController as AdminPersonalReadingController;
use App\Http\Controllers\Admin\Personal\RecipeController as AdminPersonalRecipeController;
use App\Http\Controllers\Admin\Personal\RecipeIngredientController as AdminPersonalRecipeIngredientController;
use App\Http\Controllers\Admin\Personal\RecipeStepController as AdminPersonalRecipeStepController;
use App\Http\Controllers\Admin\Personal\UnitController as AdminPersonalUnitController;
use App\Http\Controllers\Admin\Root\Personal\IndexController as AdminRootPersonalIndexController;
use App\Http\Controllers\Admin\Root\Personal\IngredientController as AdminRootPersonalIngredientController;
use App\Http\Controllers\Admin\Root\Personal\ReadingController as AdminRootPersonalReadingController;
use App\Http\Controllers\Admin\Root\Personal\RecipeController as AdminRootPersonalRecipeController;
use App\Http\Controllers\Admin\Root\Personal\RecipeIngredientController as AdminRootPersonalRecipeIngredientController;
use App\Http\Controllers\Admin\Root\Personal\RecipeStepController as AdminRootPersonalRecipeStepController;
use App\Http\Controllers\Admin\Root\Personal\UnitController as AdminRootPersonalUnitController;
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

Route::prefix('admin/admin')->middleware('admin')->name('root.personal.')->group(function () {

    Route::get('personal', [AdminRootPersonalIndexController::class, 'index'])->name('index');

    Route::resource('personal/ingredient', AdminRootPersonalIngredientController::class);
    Route::resource('personal/unit', AdminRootPersonalUnitController::class);

    Route::resource('{admin:id}/personal/reading', AdminRootPersonalReadingController::class);
    Route::resource('{admin:id}/personal/recipe', AdminRootPersonalRecipeController::class);
    Route::resource('{admin:id}/personal/recipe-ingredient', AdminRootPersonalRecipeIngredientController::class)->parameter('recipe-ingredient', 'recipe_ingredient');
    Route::resource('{admin:id}/personal/recipe-step', AdminRootPersonalRecipeStepController::class)->parameter('recipe-step', 'recipe_step');
});

Route::name('guest.')->middleware('guest')->group(function () {
    Route::get('/{admin:label}/personal', [GuestPersonalIndexController::class, 'index'])->name('personal.index');
    Route::get('/{admin:label}/personal/reading', [GuestPersonalReadingController::class, 'index'])->name('personal.reading.index');
    Route::get('/{admin:label}/personal/reading/{slug}', [GuestPersonalReadingController::class, 'show'])->name('personal.reading.show');
    Route::get('/{admin:label}/personal/recipe', [GuestPersonalRecipeController::class, 'index'])->name('personal.recipe.index');
    Route::get('/{admin:label}/personal/recipe/{slug}', [GuestPersonalRecipeController::class, 'show'])->name('personal.recipe.show');
});
