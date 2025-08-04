<?php

use App\Http\Controllers\Front\CertificateController;
use App\Http\Controllers\Front\IndexController;
use App\Http\Controllers\Front\LinkController;
use App\Http\Controllers\Front\ProjectController;
use App\Http\Controllers\Front\ReadingController;
use App\Http\Controllers\Front\VideoController;
use App\Http\Controllers\User\IndexController as UserIndexController;

use Illuminate\Support\Facades\Route;

Route::get('/', [UserIndexController::class, 'index'])->name('homepage');
Route::get('/about', [IndexController::class, 'about'])->name('about');
Route::get('/certificate', [CertificateController::class, 'index'])->name('certificate.index');
Route::get('/contact', [IndexController::class, 'contact'])->name('contact');
Route::get('/link', [LinkController::class, 'index'])->name('link.index');
Route::get('/privacy-policy', [IndexController::class, 'privacy_policy'])->name('privacy_policy');
Route::get('/project', [ProjectController::class, 'index'])->name('project.index');
Route::get('/reading', [ReadingController::class, 'index'])->name('reading.index');
Route::get('/terms-and-conditions', [IndexController::class, 'terms_and_conditions'])->name('terms_and_conditions');
Route::get('/video', [VideoController::class, 'index'])->name('video.index');
