<?php

// The following were copied to the system.php routes file.
use App\Http\Controllers\Guest\Dictionary\CategoryController as GuestDictionaryCategoryController;
use App\Http\Controllers\Guest\Dictionary\DatabaseController as GuestDictionaryDatabaseController;
use App\Http\Controllers\Guest\Dictionary\FrameworkController as GuestDictionaryFrameworkController;
use App\Http\Controllers\Guest\Dictionary\IndexController as GuestDictionaryIndexController;
use App\Http\Controllers\Guest\Dictionary\LanguageController as GuestDictionaryLanguageController;
use App\Http\Controllers\Guest\Dictionary\LibraryController as GuestDictionaryLibraryController;
use App\Http\Controllers\Guest\Dictionary\OperatingSystemController as GuestDictionaryOperatingSystemController;
use App\Http\Controllers\Guest\Dictionary\ServerController as GuestDictionaryServerController;
use App\Http\Controllers\Guest\Dictionary\StackController as GuestDictionaryStackController;

use App\Http\Controllers\Admin\Dictionary\CategoryController as AdminDictionaryCategoryController;
use App\Http\Controllers\Admin\Dictionary\DatabaseController as AdminDictionaryDatabaseController;
use App\Http\Controllers\Admin\Dictionary\FrameworkController as AdminDictionaryFrameworkController;
use App\Http\Controllers\Admin\Dictionary\IndexController as AdminDictionaryIndexController;
use App\Http\Controllers\Admin\Dictionary\LanguageController as AdminDictionaryLanguageController;
use App\Http\Controllers\Admin\Dictionary\LibraryController as AdminDictionaryLibraryController;
use App\Http\Controllers\Admin\Dictionary\OperatingSystemController as AdminDictionaryOperatingSystemController;
use App\Http\Controllers\Admin\Dictionary\ServerController as AdminDictionaryServerController;
use App\Http\Controllers\Admin\Dictionary\StackController as AdminDictionaryStackController;

use Illuminate\Support\Facades\Route;

/*
// The following were copied to the system.php routes file.
Route::prefix('dictionary')->middleware('guest')->name('guest.dictionary.')->group(function () {
    Route::get('/', [GuestDictionaryIndexController::class, 'index'])->name('index');
    Route::get('/category', [GuestDictionaryCategoryController::class, 'index'])->name('category.index');
    Route::get('/category/{slug}', [GuestDictionaryCategoryController::class, 'show'])->name('category.show');
    Route::get('/database', [GuestDictionaryDatabaseController::class, 'index'])->name('database.index');
    Route::get('/database/{slug}', [GuestDictionaryDatabaseController::class, 'show'])->name('database.show');
    Route::get('/framework', [GuestDictionaryFrameworkController::class, 'index'])->name('framework.index');
    Route::get('/framework/{slug}', [GuestDictionaryFrameworkController::class, 'show'])->name('framework.show');
    Route::get('/language', [GuestDictionaryLanguageController::class, 'index'])->name('language.index');
    Route::get('/language/{slug}', [GuestDictionaryLanguageController::class, 'show'])->name('language.show');
    Route::get('/library', [GuestDictionaryLibraryController::class, 'index'])->name('library.index');
    Route::get('/library/{slug}', [GuestDictionaryLibraryController::class, 'show'])->name('library.show');
    Route::get('/operating-system', [GuestDictionaryOperatingSystemController::class, 'index'])->name('operating-system.index');
    Route::get('/operating-system/{slug}', [GuestDictionaryOperatingSystemController::class, 'show'])->name('operating-system.show');
    Route::get('/server', [GuestDictionaryServerController::class, 'index'])->name('server.index');
    Route::get('/server/{slug}', [GuestDictionaryServerController::class, 'show'])->name('server.show');
    Route::get('/stack', [GuestDictionaryStackController::class, 'index'])->name('stack.index');
    Route::get('/stack/{slug}', [GuestDictionaryStackController::class, 'show'])->name('stack.show');
});
*/

Route::prefix('admin/dictionary')->middleware('admin')->name('admin.dictionary.')->group(function () {
    Route::get('/', [AdminDictionaryIndexController::class, 'index'])->name('index');
    Route::resource('category', AdminDictionaryCategoryController::class)->parameter('category', 'category');
    Route::resource('database', AdminDictionaryDatabaseController::class)->parameter('database', 'database');
    Route::resource('framework', AdminDictionaryFrameworkController::class)->parameter('framework', 'framework');
    Route::resource('language', AdminDictionaryLanguageController::class)->parameter('language', 'language');
    Route::resource('library', AdminDictionaryLibraryController::class)->parameter('library', 'library');
    Route::resource('operating-system', AdminDictionaryOperatingSystemController::class)->parameter('operating-system', 'operating_system');
    Route::resource('server', AdminDictionaryServerController::class)->parameter('server', 'server');
    Route::resource('stack', AdminDictionaryStackController::class)->parameter('stack', 'stack');
});
