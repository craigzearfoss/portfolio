<?php

use App\Http\Controllers\Front\Dictionary\CategoryController as FrontCategoryController;
use App\Http\Controllers\Front\Dictionary\DatabaseController as FrontDatabaseController;
use App\Http\Controllers\Front\Dictionary\FrameworkController as FrontFrameworkController;
use App\Http\Controllers\Front\Dictionary\IndexController as FrontIndexController;
use App\Http\Controllers\Front\Dictionary\LanguageController as FrontLanguageController;
use App\Http\Controllers\Front\Dictionary\LibraryController as FrontLibraryController;
use App\Http\Controllers\Front\Dictionary\OperatingSystemController as FrontOperatingSystemController;
use App\Http\Controllers\Front\Dictionary\ServerController as FrontServerController;
use App\Http\Controllers\Front\Dictionary\StackController as FrontStackController;

use App\Http\Controllers\Admin\Dictionary\CategoryController as AdminCategoryController;
use App\Http\Controllers\Admin\Dictionary\DatabaseController as AdminDatabaseController;
use App\Http\Controllers\Admin\Dictionary\FrameworkController as AdminFrameworkController;
use App\Http\Controllers\Admin\Dictionary\IndexController as AdminIndexController;
use App\Http\Controllers\Admin\Dictionary\LanguageController as AdminLanguageController;
use App\Http\Controllers\Admin\Dictionary\LibraryController as AdminLibraryController;
use App\Http\Controllers\Admin\Dictionary\OperatingSystemController as AdminOperatingSystemController;
use App\Http\Controllers\Admin\Dictionary\ServerController as AdminServerController;
use App\Http\Controllers\Admin\Dictionary\StackController as AdminStackController;

use Illuminate\Support\Facades\Route;

Route::prefix('dictionary')->name('front.dictionary.')->group(function () {
    Route::get('/', [FrontIndexController::class, 'index'])->name('index');
    Route::get('/category', [FrontCategoryController::class, 'index'])->name('category.index');
    Route::get('/category/{slug}', [FrontCategoryController::class, 'show'])->name('category.show');
    Route::get('/database', [FrontDatabaseController::class, 'index'])->name('database.index');
    Route::get('/database/{slug}', [FrontDatabaseController::class, 'show'])->name('database.show');
    Route::get('/framework', [FrontFrameworkController::class, 'index'])->name('framework.index');
    Route::get('/framework/{slug}', [FrontFrameworkController::class, 'show'])->name('framework.show');
    Route::get('/language', [FrontLanguageController::class, 'index'])->name('language.index');
    Route::get('/language/{slug}', [FrontLanguageController::class, 'show'])->name('language.show');
    Route::get('/library', [FrontLibraryController::class, 'index'])->name('library.index');
    Route::get('/library/{slug}', [FrontLibraryController::class, 'show'])->name('library.show');
    Route::get('/operating-system', [FrontOperatingSystemController::class, 'index'])->name('operating-system.index');
    Route::get('/operating-system/{slug}', [FrontOperatingSystemController::class, 'show'])->name('operating-system.show');
    Route::get('/server', [FrontServerController::class, 'index'])->name('server.index');
    Route::get('/server/{slug}', [FrontServerController::class, 'show'])->name('server.show');
    Route::get('/stack', [FrontStackController::class, 'index'])->name('stack.index');
    Route::get('/stack/{slug}', [FrontStackController::class, 'show'])->name('stack.show');
});

Route::prefix('admin/dictionary')->middleware('admin')->name('admin.dictionary.')->group(function () {
    Route::get('/', [AdminIndexController::class, 'index'])->name('index');
    Route::resource('category', AdminCategoryController::class)->parameter('category', 'category');
    Route::resource('database', AdminDatabaseController::class)->parameter('database', 'database');
    Route::resource('framework', AdminFrameworkController::class)->parameter('framework', 'framework');
    Route::resource('language', AdminLanguageController::class)->parameter('language', 'language');
    Route::resource('library', AdminLibraryController::class)->parameter('library', 'library');
    Route::resource('operating-system', AdminOperatingSystemController::class)->parameter('operating-system', 'operating_system');
    Route::resource('server', AdminServerController::class)->parameter('server', 'server');
    Route::resource('stack', AdminStackController::class)->parameter('stack', 'stack');
});
