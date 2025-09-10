<?php

use App\Http\Controllers\Front\ArtController;
use App\Http\Controllers\Front\CertificationController;
use App\Http\Controllers\Front\CourseController;
use App\Http\Controllers\Front\IndexController;
use App\Http\Controllers\Front\LinkController;
use App\Http\Controllers\Front\MusicController;
use App\Http\Controllers\Front\ProjectController;
use App\Http\Controllers\Front\ReadingController;
use App\Http\Controllers\Front\RecipeController;
use App\Http\Controllers\Front\VideoController;

use App\Http\Controllers\Front\Dictionary\IndexController as DictionaryController;
use App\Http\Controllers\Front\Dictionary\CategoryController as DictionaryCategoryController;
use App\Http\Controllers\Front\Dictionary\DatabaseController as DictionaryDatabaseController;
use App\Http\Controllers\Front\Dictionary\FrameworkController as DictionaryFrameworkController;
use App\Http\Controllers\Front\Dictionary\LanguageController as DictionaryLanguageController;
use App\Http\Controllers\Front\Dictionary\LibraryController as DictionaryLibraryController;
use App\Http\Controllers\Front\Dictionary\OperatingSystemController as DictionaryOperatingSystemController;
use App\Http\Controllers\Front\Dictionary\ServerController as DictionaryServerController;
use App\Http\Controllers\Front\Dictionary\StackController as DictionaryStackController;

use Illuminate\Support\Facades\Route;

Route::name('front.')->group(function () {

    Route::get('/', [IndexController::class, 'index'])->name('homepage');
    Route::get('/about', [IndexController::class, 'about'])->name('about');
    Route::get('/contact', [IndexController::class, 'contact'])->name('contact');
    Route::get('/forgot-password', [IndexController::class, 'forgot_password'])->name('forgot-password');
    Route::post('/forgot-password', [IndexController::class, 'forgot_password'])->name('forgot-password-submit');
    Route::get('/forgot-username', [IndexController::class, 'forgot_username'])->name('forgot-username');
    Route::post('/forgot-username', [IndexController::class, 'forgot_username'])->name('forgot-username-submit');
    Route::get('/login', [IndexController::class, 'login'])->name('login');
    Route::post('/login', [IndexController::class, 'login'])->name('login-submit');
    Route::get('/privacy-policy', [IndexController::class, 'privacy_policy'])->name('privacy-policy');
    Route::get('/register', [IndexController::class, 'register'])->name('register');
    Route::post('/register', [IndexController::class, 'register'])->name('register-submit');
    Route::get('/reset-password/{token}/{email}', [IndexController::class, 'reset_password'])->name('reset-password');
    Route::post('/reset-password/{token}/{email}', [IndexController::class, 'reset_password_submit'])->name('reset-password-submit');
    Route::get('/terms-and-conditions', [IndexController::class, 'terms_and_conditions'])->name('terms-and-conditions');
    Route::get('/verify-email/{token}/{email}', [IndexController::class, 'email_verification'])->name('email-verification');

    // resources
    Route::get('/art', [ArtController::class, 'index'])->name('art.index');
    Route::get('/art/{slug}', [ArtController::class, 'show'])->name('art.show');
    Route::get('/certifications', [CertificationController::class, 'index'])->name('certification.index');
    Route::get('/certification/{slug}', [CertificationController::class, 'show'])->name('certification.show');
    Route::get('/courses', [CourseController::class, 'index'])->name('course.index');
    Route::get('/course/{slug}', [CourseController::class, 'show'])->name('course.show');
    Route::get('/links', [LinkController::class, 'index'])->name('link.index');
    Route::get('/link/{slug}', [LinkController::class, 'show'])->name('link.show');
    Route::get('/music', [MusicController::class, 'index'])->name('music.index');
    Route::get('/music/{slug}', [MusicController::class, 'show'])->name('music.show');
    Route::get('/projects', [ProjectController::class, 'index'])->name('project.index');
    Route::get('/project/{slug}', [ProjectController::class, 'show'])->name('project.show');
    Route::get('/readings', [ReadingController::class, 'index'])->name('reading.index');
    Route::get('/reading/{slug}', [ReadingController::class, 'show'])->name('reading.show');
    Route::get('/recipes', [RecipeController::class, 'index'])->name('recipe.index');
    Route::get('/recipe/{slug}', [RecipeController::class, 'show'])->name('recipe.show');
    Route::get('/videos', [VideoController::class, 'index'])->name('video.index');
    Route::get('/video/{slug}', [VideoController::class, 'show'])->name('video.show');
});

Route::prefix('dictionary')->name('front.dictionary.')->group(function () {
    Route::get('/', [DictionaryController::class, 'index'])->name('index');
    Route::get('/category', [DictionaryCategoryController::class, 'index'])->name('category.show');
    Route::get('/category/{category}', [DictionaryCategoryController::class, 'show'])->name('category.index');
    Route::get('/database', [DictionaryDatabaseController::class, 'index'])->name('database.show');
    Route::get('/database/{database}', [DictionaryDatabaseController::class, 'show'])->name('database.index');
    Route::get('/framework', [DictionaryFrameworkController::class, 'index'])->name('framework.show');
    Route::get('/framework/{framework}', [DictionaryFrameworkController::class, 'show'])->name('framework.index');
    Route::get('/language', [DictionaryLanguageController::class, 'index'])->name('language.show');
    Route::get('/language/{language}', [DictionaryLanguageController::class, 'show'])->name('language.index');
    Route::get('/library', [DictionaryLibraryController::class, 'index'])->name('library.show');
    Route::get('/library/{library}', [DictionaryLibraryController::class, 'show'])->name('library.index');
    Route::get('/operating-system', [DictionaryOperatingSystemController::class, 'index'])->name('operating-system.show');
    Route::get('/operating-system/{operatingSystem}', [DictionaryOperatingSystemController::class, 'show'])->name('operating-system.index');
    Route::get('/server', [DictionaryServerController::class, 'index'])->name('server.show');
    Route::get('/server/{server}', [DictionaryServerController::class, 'show'])->name('server.index');
    Route::get('/stack', [DictionaryStackController::class, 'index'])->name('stack.show');
    Route::get('/stack/{stack}', [DictionaryStackController::class, 'show'])->name('stack.index');
});

