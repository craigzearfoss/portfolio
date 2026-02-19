<?php

use App\Http\Controllers\Admin\IndexController as AdminIndexController;
use App\Http\Controllers\Admin\ProfileController as AdminProfileController;
use App\Http\Controllers\Admin\System\AdminController as AdminSystemAdminController;
use App\Http\Controllers\Admin\System\AdminDatabaseController as AdminSystemAdminDatabaseController;
use App\Http\Controllers\Admin\System\AdminEmailController as AdminSystemAdminEmailController;
use App\Http\Controllers\Admin\System\AdminGroupController as AdminSystemAdminGroupController;
use App\Http\Controllers\Admin\System\AdminPhoneController as AdminSystemAdminPhoneController;
use App\Http\Controllers\Admin\System\AdminResourceController as AdminSystemAdminResourceController;
use App\Http\Controllers\Admin\System\AdminTeamController as AdminSystemAdminTeamController;
use App\Http\Controllers\Admin\System\DatabaseController as AdminSystemDatabaseController;
use App\Http\Controllers\Admin\System\IndexController as AdminSystemIndexController;
use App\Http\Controllers\Admin\System\LogController as AdminSystemLogController;
use App\Http\Controllers\Admin\System\MessageController as AdminMessageController;
use App\Http\Controllers\Admin\System\ResourceController as AdminSystemResourceController;
use App\Http\Controllers\Admin\System\SessionController as AdminSystemSessionController;
use App\Http\Controllers\Admin\System\SettingController as AdminSystemSettingController;
use App\Http\Controllers\Admin\System\UserController as AdminSystemUserController;
use App\Http\Controllers\Admin\System\UserEmailController as AdminSystemUserEmailController;
use App\Http\Controllers\Admin\System\UserGroupController as AdminSystemUserGroupController;
use App\Http\Controllers\Admin\System\UserPhoneController as AdminSystemUserPhoneController;
use App\Http\Controllers\Admin\System\UserTeamController as AdminSystemUserTeamController;

use App\Http\Controllers\Guest\IndexController as GuestIndexController;
use App\Http\Controllers\Guest\System\AdminController as GuestSystemAdminController;
use App\Http\Controllers\Guest\System\UserController as GuestSystemUserController;
use App\Http\Controllers\IndexController as IndexController;
use App\Http\Controllers\User\IndexController as UserIndexController;
use App\Http\Controllers\User\ProfileController as UserProfileController;
use Illuminate\Support\Facades\Route;

// The following were copied from the dictionary.php routes file.
use App\Http\Controllers\Guest\Dictionary\CategoryController as GuestDictionaryCategoryController;
use App\Http\Controllers\Guest\Dictionary\DatabaseController as GuestDictionaryDatabaseController;
use App\Http\Controllers\Guest\Dictionary\FrameworkController as GuestDictionaryFrameworkController;
use App\Http\Controllers\Guest\Dictionary\IndexController as GuestDictionaryIndexController;
use App\Http\Controllers\Guest\Dictionary\LanguageController as GuestDictionaryLanguageController;
use App\Http\Controllers\Guest\Dictionary\LibraryController as GuestDictionaryLibraryController;
use App\Http\Controllers\Guest\Dictionary\OperatingSystemController as GuestDictionaryOperatingSystemController;
use App\Http\Controllers\Guest\Dictionary\ServerController as GuestDictionaryServerController;
use App\Http\Controllers\Guest\Dictionary\StackController as GuestDictionaryStackController;

// ---------------------------------------------------------------------------------------------------------------------
// base routes
// ---------------------------------------------------------------------------------------------------------------------
Route::get('about', [IndexController::class, 'about'])->name('about');
Route::get('contact', [IndexController::class, 'contact'])->name('contact');
Route::post('contact/store', [IndexController::class, 'storeMessage'])->name('contact.storeMessage');
Route::get('privacy-policy', [IndexController::class, 'privacy_policy'])->name('privacy-policy');
Route::get('terms-and-conditions', [IndexController::class, 'terms_and_conditions'])->name('terms-and-conditions');

Route::get('candidates', [GuestIndexController::class, 'candidates'])->name('guest.admin.index');


Route::get('download-from-public', [IndexController::class, 'download_from_public'])->name('download-from-public');
Route::get('view-document', [IndexController::class, 'view_document'])->name('view-document');

// ---------------------------------------------------------------------------------------------------------------------
// user routes
// ---------------------------------------------------------------------------------------------------------------------
Route::name('user.')->group(function () {
    Route::get('/forgot-password', [UserIndexController::class, 'forgot_password'])->name('forgot-password');
    Route::post('/forgot-password', [UserIndexController::class, 'forgot_password'])->name('forgot-password-submit');
    Route::get('/forgot-username', [UserIndexController::class, 'forgot_username'])->name('forgot-username');
    Route::post('/forgot-username', [UserIndexController::class, 'forgot_username'])->name('forgot-username-submit');
    Route::post('/login', [UserIndexController::class, 'login'])->middleware('throttle:login')->name('login-submit');
    Route::get('/login', [UserIndexController::class, 'login'])->name('login');
    Route::get('/logout', [UserIndexController::class, 'logout'])->name('logout');
    Route::get('/register', [UserIndexController::class, 'register'])->name('register');
    Route::post('/register', [UserIndexController::class, 'register'])->name('register-submit');
    Route::get('/reset-password/{token}/{email}', [UserIndexController::class, 'reset_password'])->name('reset-password');
    Route::post('/reset-password/{token}/{email}', [UserIndexController::class, 'reset_password_submit'])->name('reset-password-submit');
    Route::get('/verify-email/{token}/{email}', [UserIndexController::class, 'email_verification'])->name('email-verification');

    // protected area
    Route::middleware('user')->group(function () {
        Route::get('/dashboard', [UserIndexController::class, 'dashboard'])->name('dashboard');
        Route::get('/profile/change-password', [UserProfileController::class, 'change_password'])->name('change-password');
        Route::put('/profile/change-password', [UserProfileController::class, 'change_password_submit'])->name('change-password-submit');
        Route::get('/profile', [UserProfileController::class, 'show'])->name('show');
        Route::get('/profile/edit', [UserProfileController::class, 'edit'])->name('edit');
        Route::put('/profile/update/{user}', [UserProfileController::class, 'update'])->name('update');
    });
});

// ---------------------------------------------------------------------------------------------------------------------
// admin routes
// ---------------------------------------------------------------------------------------------------------------------
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('about', [IndexController::class, 'about'])->name('about');
    Route::get('contact', [IndexController::class, 'contact'])->name('contact');
    Route::post('contact/store', [IndexController::class, 'storeMessage'])->name('contact.storeMessage');
    Route::get('privacy-policy', [IndexController::class, 'privacy_policy'])->name('privacy-policy');
    Route::get('terms-and-conditions', [IndexController::class, 'terms_and_conditions'])->name('terms-and-conditions');

    Route::get('forgot-password', [AdminIndexController::class, 'forgot_password'])->name('forgot-password');
    Route::post('forgot-password', [AdminIndexController::class, 'forgot_password'])->name('forgot-password-submit');
    Route::get('forgot-username', [AdminIndexController::class, 'forgot_username'])->name('forgot-username');
    Route::post('forgot-username', [AdminIndexController::class, 'forgot_username'])->name('forgot-username-submit');
    Route::get('login', [AdminIndexController::class, 'login'])->name('login');
    Route::post('login', [AdminIndexController::class, 'login'])->middleware('throttle:login')->name('login-submit');
    Route::get('logout', [AdminIndexController::class, 'logout'])->name('logout');
    Route::get('reset-password/{token}/{email}', [AdminIndexController::class, 'reset_password'])->name('reset-password');
    Route::post('reset-password/{token}/{email}', [AdminIndexController::class, 'reset_password_submit'])->name('reset-password-submit');

    // protected area
    Route::middleware('admin')->group(function () {
        Route::get('/', [AdminIndexController::class, 'index'])->name('index');
        Route::get('dashboard', [AdminIndexController::class, 'dashboard'])->name('dashboard');
        Route::get('/download-from-storage', [IndexController::class, 'download_from_storage'])->name('download-from-storage');
        Route::get('profile', [AdminProfileController::class, 'show'])->name('profile.show');
        Route::get('profile/change-password', [AdminProfileController::class, 'change_password'])->name('profile.change-password');
        Route::put('profile/change-password', [AdminProfileController::class, 'change_password_submit'])->name('profile.change-password-submit');
        Route::get('profile/edit', [AdminProfileController::class, 'edit'])->name('profile.edit');
        Route::put('profile/update/{admin}', [AdminProfileController::class, 'update'])->name('profile.update');

        Route::name('system.')->group(function () {
            //Route::resource('admin', AdminSystemAdminController::class);
            Route::get('admin', [AdminSystemAdminController::class, 'index'])->name('admin.index');
            Route::get('admin/create', [AdminSystemAdminController::class, 'create'])->name('admin.create');
            Route::post('admin', [AdminSystemAdminController::class, 'store'])->name('admin.store');
            Route::get('admin/{admin}', [AdminSystemAdminController::class, 'show'])->name('admin.show');
            Route::get('admin/{admin}/edit', [AdminSystemAdminController::class, 'edit'])->name('admin.edit');
            Route::get('admin/{admin}/profile', [AdminSystemAdminController::class, 'profile'])->name('admin.profile');
            Route::put('admin/{admin}', [AdminSystemAdminController::class, 'update'])->name('admin.update');
            Route::put('admin/{admin}/delete', [AdminSystemAdminController::class, 'destroy'])->name('admin.destroy');
            Route::get('admin/{admin}/change-password', [AdminSystemUserController::class, 'change_password'])->name('admin.change-password');
            Route::post('admin/{admin}/change-password', [AdminSystemUserController::class, 'change_password_submit'])->name('admin.change-password-submit');
            Route::resource('admin-email', AdminSystemAdminEmailController::class)->parameter('admin-email', 'admin_email');
            Route::resource('admin-group', AdminSystemAdminGroupController::class)->parameter('admin-group', 'admin_group');
            Route::resource('admin-phone', AdminSystemAdminPhoneController::class)->parameter('admin-phone', 'admin_phone');
            Route::resource('admin-team', AdminSystemAdminTeamController::class)->parameter('admin-team', 'admin_team');
            Route::resource('database', AdminSystemDatabaseController::class);
            Route::resource('admin-database', AdminSystemAdminDatabaseController::class)->parameter('admin-database', 'admin_database');
            Route::resource('log', AdminSystemLogController::class);
            Route::resource('message', AdminMessageController::class);
            Route::resource('resource', AdminSystemResourceController::class);
            Route::resource('admin-resource', AdminSystemAdminResourceController::class)->parameter('admin-resource', 'admin_resource');
            Route::resource('session', AdminSystemSessionController::class);
            Route::resource('setting', AdminSystemSettingController::class);
            Route::get('system/', [AdminSystemIndexController::class, 'index'])->name('index');
            Route::resource('user', AdminSystemUserController::class);
            Route::get('user/{user}/change-password', [AdminSystemUserController::class, 'change_password'])->name('user.change-password');
            Route::post('user/{user}/change-password', [AdminSystemUserController::class, 'change_password_submit'])->name('user.change-password-submit');
            Route::resource('user-email', AdminSystemUserEmailController::class)->parameter('user-email', 'user_email');
            Route::resource('user-group', AdminSystemUserGroupController::class)->parameter('user-group', 'user_group');
            Route::resource('user-phone', AdminSystemUserPhoneController::class)->parameter('user-phone', 'user_phone');
            Route::resource('user-team', AdminSystemUserTeamController::class)->parameter('user-team', 'user_team');
        });
    });
});

// ---------------------------------------------------------------------------------------------------------------------
// guest dictionary routes
// Copied from dictionary.php routes file.
// ---------------------------------------------------------------------------------------------------------------------
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

// ---------------------------------------------------------------------------------------------------------------------
// guest routes
// ---------------------------------------------------------------------------------------------------------------------
Route::get('{admin:label}', [GuestSystemAdminController::class, 'show'])->name('guest.admin.show');

Route::name('guest.')->group(function () {
    Route::get('/', [GuestIndexController::class, 'index'])->name('index');
    Route::get('/user', [GuestSystemUserController::class, 'index'])->name('user.index');
    Route::get('/user/{user:id}', [GuestSystemUserController::class, 'index'])->name('user.show');
});

