<?php

use App\Http\Controllers\CaptchaController;
use Illuminate\Support\Facades\Route;

Route::get('/', [CaptchaController::class, 'index']);
Route::post('/captcha-validation', [CaptchaController::class, 'captchaFormValidate']);
Route::get('/reload-captcha', [CaptchaController::class, 'reloadCaptcha']);
