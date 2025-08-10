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
use App\Http\Controllers\User\IndexController as UserIndexController;

use Illuminate\Support\Facades\Route;

Route::get('/', [UserIndexController::class, 'index'])->name('homepage');
Route::get('/about', [IndexController::class, 'about'])->name('about');
Route::get('/art', [ArtController::class, 'index'])->name('art.index');
Route::get('/art/{slug}', [ArtController::class, 'show'])->name('art.show');
Route::get('/certifications', [CertificationController::class, 'index'])->name('certification.index');
Route::get('/certification/{slug}', [CertificationController::class, 'show'])->name('certification.show');
Route::get('/courses', [CourseController::class, 'index'])->name('course.index');
Route::post('/course/{slug}', [CourseController::class, 'show'])->name('course.show');
Route::get('/links', [LinkController::class, 'index'])->name('link.index');
Route::get('/link/{slug}', [LinkController::class, 'show'])->name('link.show');
Route::get('/music', [MusicController::class, 'index'])->name('music.index');
Route::get('/music/{slug}', [MusicController::class, 'show'])->name('music.show');
Route::get('/privacy-policy', [IndexController::class, 'privacy_policy'])->name('privacy_policy');
Route::get('/projects', [ProjectController::class, 'index'])->name('project.index');
Route::get('/project/{slug}', [ProjectController::class, 'show'])->name('project.show');
Route::get('/readings', [ReadingController::class, 'index'])->name('reading.index');
Route::get('/reading/{slug}', [ReadingController::class, 'show'])->name('reading.show');
Route::get('/recipes', [RecipeController::class, 'index'])->name('recipe.index');
Route::get('/recipe/{slug}', [RecipeController::class, 'show'])->name('recipe.show');
Route::get('/terms-and-conditions', [IndexController::class, 'terms_and_conditions'])->name('terms_and_conditions');
Route::get('/videos', [VideoController::class, 'index'])->name('video.index');
Route::get('/video/{slug}', [VideoController::class, 'show'])->name('video.show');
