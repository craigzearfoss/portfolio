<?php

use App\Http\Controllers\Guest\Dictionary\CategoryController as GuestCategoryController;
use App\Http\Controllers\Guest\Dictionary\DatabaseController as GuestDatabaseController;
use App\Http\Controllers\Guest\Dictionary\FrameworkController as GuestFrameworkController;
use App\Http\Controllers\Guest\Dictionary\IndexController as GuestIndexController;
use App\Http\Controllers\Guest\Dictionary\LanguageController as GuestLanguageController;
use App\Http\Controllers\Guest\Dictionary\LibraryController as GuestLibraryController;
use App\Http\Controllers\Guest\Dictionary\OperatingSystemController as GuestOperatingSystemController;
use App\Http\Controllers\Guest\Dictionary\ServerController as GuestServerController;
use App\Http\Controllers\Guest\Dictionary\StackController as GuestStackController;

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

Route::prefix('dictionary')->middleware('guest')->name('guest.dictionary.')->group(function () {
    Route::get('/', [GuestIndexController::class, 'index'])->name('index');
    Route::get('/category', [GuestCategoryController::class, 'index'])->name('category.index');
    Route::get('/category/{slug}', [GuestCategoryController::class, 'show'])->name('category.show');
    Route::get('/database', [GuestDatabaseController::class, 'index'])->name('database.index');
    Route::get('/database/{slug}', [GuestDatabaseController::class, 'show'])->name('database.show');
    Route::get('/framework', [GuestFrameworkController::class, 'index'])->name('framework.index');
    Route::get('/framework/{slug}', [GuestFrameworkController::class, 'show'])->name('framework.show');
    Route::get('/language', [GuestLanguageController::class, 'index'])->name('language.index');
    Route::get('/language/{slug}', [GuestLanguageController::class, 'show'])->name('language.show');
    Route::get('/library', [GuestLibraryController::class, 'index'])->name('library.index');
    Route::get('/library/{slug}', [GuestLibraryController::class, 'show'])->name('library.show');
    Route::get('/operating-system', [GuestOperatingSystemController::class, 'index'])->name('operating-system.index');
    Route::get('/operating-system/{slug}', [GuestOperatingSystemController::class, 'show'])->name('operating-system.show');
    Route::get('/server', [GuestServerController::class, 'index'])->name('server.index');
    Route::get('/server/{slug}', [GuestServerController::class, 'show'])->name('server.show');
    Route::get('/stack', [GuestStackController::class, 'index'])->name('stack.index');
    Route::get('/stack/{slug}', [GuestStackController::class, 'show'])->name('stack.show');
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
