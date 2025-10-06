<?php

/*Route::name('front.')->group(function () {

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
    Route::prefix('portfolio')->name('front')->group(function () {
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
});

Route::prefix('dictionary')->name('front.dictionary.')->group(function () {
    Route::get('/', [DictionaryController::class, 'index'])->name('index');
    Route::get('/category', [DictionaryCategoryController::class, 'index'])->name('category.index');
    Route::get('/category/{slug}', [DictionaryCategoryController::class, 'show'])->name('category.show');
    Route::get('/database', [DictionaryDatabaseController::class, 'index'])->name('database.index');
    Route::get('/database/{slug}', [DictionaryDatabaseController::class, 'show'])->name('database.show');
    Route::get('/framework', [DictionaryFrameworkController::class, 'index'])->name('framework.index');
    Route::get('/framework/{slug}', [DictionaryFrameworkController::class, 'show'])->name('framework.show');
    Route::get('/language', [DictionaryLanguageController::class, 'index'])->name('language.index');
    Route::get('/language/{slug}', [DictionaryLanguageController::class, 'show'])->name('language.show');
    Route::get('/library', [DictionaryLibraryController::class, 'index'])->name('library.index');
    Route::get('/library/{slug}', [DictionaryLibraryController::class, 'show'])->name('library.show');
    Route::get('/operating-system', [DictionaryOperatingSystemController::class, 'index'])->name('operating-system.index');
    Route::get('/operating-system/{slug}', [DictionaryOperatingSystemController::class, 'show'])->name('operating-system.show');
    Route::get('/server', [DictionaryServerController::class, 'index'])->name('server.index');
    Route::get('/server/{slug}', [DictionaryServerController::class, 'show'])->name('server.show');
    Route::get('/stack', [DictionaryStackController::class, 'index'])->name('stack.index');
    Route::get('/stack/{slug}', [DictionaryStackController::class, 'show'])->name('stack.show');
});*/
