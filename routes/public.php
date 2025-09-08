<?php


use App\Http\Controllers\Admin\Dictionary\IndexController as DictionaryController;
use App\Http\Controllers\Admin\Dictionary\CategoryController as DictionaryCategoryController;
use App\Http\Controllers\Admin\Dictionary\DatabaseController as DictionaryDatabaseController;
use App\Http\Controllers\Admin\Dictionary\FrameworkController as DictionaryFrameworkController;
use App\Http\Controllers\Admin\Dictionary\LanguageController as DictionaryLanguageController;
use App\Http\Controllers\Admin\Dictionary\LibraryController as DictionaryLibraryController;
use App\Http\Controllers\Admin\Dictionary\OperatingSystemController as DictionaryOperatingSystemController;
use App\Http\Controllers\Admin\Dictionary\ServerController as DictionaryServerController;
use App\Http\Controllers\Admin\Dictionary\StackController as DictionaryStackController;

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
use App\Http\Controllers\User\IndexController as UserIndexController;

use Illuminate\Support\Facades\Route;

Route::name('front.')->group(function () {

    Route::get('/', [UserIndexController::class, 'index'])->name('homepage');
    Route::get('/about', [IndexController::class, 'about'])->name('about');
    Route::get('/contact', [IndexController::class, 'contact'])->name('contact');
    Route::get('/forgot-password', [IndexController::class, 'forgot_password'])->name('forgot-password');
    Route::post('/forgot-password', [IndexController::class, 'forgot_password'])->name('forgot-password-submit');
    Route::get('/login', [IndexController::class, 'login'])->name('login');
    Route::post('/login', [IndexController::class, 'login'])->name('login-submit');
    Route::get('/privacy-policy', [IndexController::class, 'privacy_policy'])->name('privacy-policy');
    Route::get('/register', [IndexController::class, 'register'])->name('register');
    Route::post('/register', [IndexController::class, 'register'])->name('register_submit');
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

Route::prefix('dictionary')->name('dictionary.')->group(function () {
    Route::get('/', [DictionaryController::class, 'index'])->name('index');
    Route::resource('category', DictionaryCategoryController::class)->parameter('category', 'category');
    Route::resource('database', DictionaryDatabaseController::class)->parameter('database', 'database');
    Route::resource('framework', DictionaryFrameworkController::class)->parameter('framework', 'framework');
    Route::resource('language', DictionaryLanguageController::class)->parameter('language', 'language');
    Route::resource('library', DictionaryLibraryController::class)->parameter('library', 'library');
    Route::resource('operating-system', DictionaryOperatingSystemController::class)->parameter('operating-system', 'operating_system');
    Route::resource('server', DictionaryServerController::class)->parameter('server', 'server');
    Route::resource('stack', DictionaryStackController::class)->parameter('stack', 'stack');
});

