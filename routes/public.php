<?php

use App\Http\Controllers\Front\ArtController;
use App\Http\Controllers\Front\CertificateController;
use App\Http\Controllers\Front\IndexController;
use App\Http\Controllers\Front\ContactController;
use App\Http\Controllers\Front\LinkController;
use App\Http\Controllers\Front\MusicController;
use App\Http\Controllers\Front\ProjectController;
use App\Http\Controllers\Front\ReadingController;
use App\Http\Controllers\Front\RecipeController;
use App\Http\Controllers\Front\VideoController;
use App\Http\Controllers\User\IndexController as UserIndexController;

use Illuminate\Support\Facades\Route;

Route::get('/', [UserIndexController::class, 'index'])->name('homepage');
Route::get('/about', [IndexController::class, 'about'])->name('about');
Route::get('/art', [ArtController::class, 'index'])->name('art.index');
Route::get('/art/{slug}', [ArtController::class, 'show'])->name('art.show');
Route::get('/certificate', [CertificateController::class, 'index'])->name('certificate.index');
Route::get('/certificate/{slug}', [CertificateController::class, 'show'])->name('certificate.show');
Route::get('/contact', [ContactController::class, 'create'])->name('contact');
Route::post('/contact', function() { die('dwd'); });
Route::post('/contact', [ContactController::class, 'store'])->name('contact-submit');
Route::get('/link', [LinkController::class, 'index'])->name('link.index');
Route::get('/link/{slug}', [LinkController::class, 'show'])->name('link.show');
Route::get('/music', [MusicController::class, 'index'])->name('music.index');
Route::get('/music/{slug}', [MusicController::class, 'show'])->name('music.show');
Route::get('/privacy-policy', [IndexController::class, 'privacy_policy'])->name('privacy_policy');
Route::get('/project', [ProjectController::class, 'index'])->name('project.index');
Route::get('/project/{slug}', [ProjectController::class, 'show'])->name('project.show');
Route::get('/reading', [ReadingController::class, 'index'])->name('reading.index');
Route::get('/reading/{slug}', [ReadingController::class, 'show'])->name('reading.show');
Route::get('/recipe', [RecipeController::class, 'index'])->name('recipe.index');
Route::get('/recipe/{slug}', [RecipeController::class, 'show'])->name('recipe.show');
Route::get('/terms-and-conditions', [IndexController::class, 'terms_and_conditions'])->name('terms_and_conditions');
Route::get('/video', [VideoController::class, 'index'])->name('video.index');
Route::get('/video/{slug}', [VideoController::class, 'show'])->name('video.show');
