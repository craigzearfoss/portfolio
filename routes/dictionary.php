<?php

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
