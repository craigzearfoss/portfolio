<?php

use App\Http\Controllers\Admin\AdminController;

use App\Http\Controllers\Admin\Career\IndexController as CareerController;
use App\Http\Controllers\Admin\Career\ApplicationController as CareerApplicationController;
use App\Http\Controllers\Admin\Career\CommunicationController as CareerCommunicationController;
use App\Http\Controllers\Admin\Career\CompanyController as CareerCompanyController;
use App\Http\Controllers\Admin\Career\ContactController as CareerContactController;
use App\Http\Controllers\Admin\Career\CoverLetterController as CareerCoverLetterController;
use App\Http\Controllers\Admin\Career\JobBoardController as CareerJobBoardController;
use App\Http\Controllers\Admin\Career\JobController as CareerJobController;
use App\Http\Controllers\Admin\Career\NoteController as CareerNoteController;
use App\Http\Controllers\Admin\Career\ReferenceController as CareerReferenceController;
use App\Http\Controllers\Admin\Career\ResumeController as CareerResumeController;
use App\Http\Controllers\Admin\Career\SkillController as CareerSkillController;

use App\Http\Controllers\Admin\IndexController;
use App\Http\Controllers\Admin\MessageController;

use App\Http\Controllers\Admin\Dictionary\IndexController as DictionaryController;
use App\Http\Controllers\Admin\Dictionary\CategoryController as DictionaryCategoryController;
use App\Http\Controllers\Admin\Dictionary\DatabaseController as DictionaryDatabaseController;
use App\Http\Controllers\Admin\Dictionary\FrameworkController as DictionaryFrameworkController;
use App\Http\Controllers\Admin\Dictionary\LanguageController as DictionaryLanguageController;
use App\Http\Controllers\Admin\Dictionary\LibraryController as DictionaryLibraryController;
use App\Http\Controllers\Admin\Dictionary\OperatingSystemController as DictionaryOperatingSystemController;
use App\Http\Controllers\Admin\Dictionary\ServerController as DictionaryServerController;
use App\Http\Controllers\Admin\Dictionary\StackController as DictionaryStackController;

use App\Http\Controllers\Admin\Portfolio\IndexController as PortfolioController;
use App\Http\Controllers\Admin\Portfolio\ArtController as PortfolioArtController;
use App\Http\Controllers\Admin\Portfolio\CertificationController as PortfolioCertificationController;
use App\Http\Controllers\Admin\Portfolio\CourseController as PortfolioCourseController;
use App\Http\Controllers\Admin\Portfolio\LinkController as PortfolioLinkController;
use App\Http\Controllers\Admin\Portfolio\MusicController as PortfolioMusicController;
use App\Http\Controllers\Admin\Portfolio\ProjectController as PortfolioProjectController;
use App\Http\Controllers\Admin\Portfolio\ReadingController as PortfolioReadingController;
use App\Http\Controllers\Admin\Portfolio\RecipeController as PortfolioRecipeController;
use App\Http\Controllers\Admin\Portfolio\RecipeIngredientController as PortfolioRecipeIngredientController;
use App\Http\Controllers\Admin\Portfolio\VideoController as PortfolioVideoController;

use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\ResourceController;
use App\Http\Controllers\Admin\UserController;
use Illuminate\Support\Facades\Route;

Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [IndexController::class, 'index'])->name('index');
    Route::get('/login', [IndexController::class, 'login'])->name('login');
    Route::post('/login', [IndexController::class, 'login'])->name('login_submit');
    Route::get('/logout', [IndexController::class, 'logout'])->name('logout');
    Route::get('/forgot-password', [IndexController::class, 'forgot_password'])->name('forgot_password');
    Route::post('/forgot-password', [IndexController::class, 'forgot_password'])->name('forgot_password_submit');
    Route::get('/reset-password/{token}/{email}', [IndexController::class, 'reset_password'])->name('reset_password');
    Route::post('/reset-password/{token}/{email}', [IndexController::class, 'reset_password_submit'])->name('reset_password_submit');
});

Route::prefix('admin/career')->middleware('admin')->name('admin.career.')->group(function () {
    Route::get('/', [CareerController::class, 'index'])->name('index');
    Route::resource('application', CareerApplicationController::class);
    Route::resource('communication', CareerCommunicationController::class);
    Route::resource('company', CareerCompanyController::class);
    Route::resource('contact', CareerContactController::class);
    Route::resource('cover-letter', CareerCoverLetterController::class);
    Route::resource('job', CareerJobController::class);
    Route::resource('job-board', CareerJobBoardController::class)->parameter('job-board', 'job_board');
    Route::resource('note', CareerNoteController::class);
    Route::resource('reference', CareerReferenceController::class);
    Route::resource('resource', ResourceController::class);
    Route::resource('resume', CareerResumeController::class);
    Route::resource('skill', CareerSkillController::class);
});

Route::prefix('admin/dictionary')->middleware('admin')->name('admin.dictionary.')->group(function () {
    Route::get('/', [DictionaryController::class, 'index'])->name('index');
    Route::resource('category', DictionaryCategoryController::class)->parameter('category', 'dictionary_category');
    Route::resource('database', DictionaryDatabaseController::class)->parameter('database', 'dictionary_database');
    Route::resource('framework', DictionaryFrameworkController::class)->parameter('framework', 'dictionary_framework');
    Route::resource('language', DictionaryLanguageController::class)->parameter('language', 'dictionary_language');
    Route::resource('library', DictionaryLibraryController::class)->parameter('library', 'dictionary_library');
    Route::resource('operating-system', DictionaryOperatingSystemController::class)->parameter('operating-system', 'dictionary_operating_system');
    Route::resource('server', DictionaryServerController::class)->parameter('server', 'dictionary_server');
    Route::resource('stack', DictionaryStackController::class)->parameter('stack', 'dictionary_stack');
});

Route::prefix('admin/portfolio')->middleware('admin')->name('admin.portfolio.')->group(function () {
    Route::get('/', [PortfolioController::class, 'index'])->name('index');
    Route::resource('art', PortfolioArtController::class);
    Route::resource('certification', PortfolioCertificationController::class);
    Route::resource('course', PortfolioCourseController::class);
    Route::resource('link', PortfolioLinkController::class);
    Route::resource('music', PortfolioMusicController::class);
    Route::resource('project', PortfolioProjectController::class);
    Route::resource('reading', PortfolioReadingController::class);
    Route::resource('recipe', PortfolioRecipeController::class);
    Route::resource('recipe-ingredient', PortfolioRecipeIngredientController::class)->parameter('recipe-ingredient', 'recipe_ingredient');
    Route::resource('video', PortfolioVideoController::class);
});

Route::prefix('admin/profile')->middleware('admin')->name('admin.portfolio.')->group(function () {
    Route::get('/', [ProfileController::class, 'show'])->name('show');
    Route::get('change-password', [ProfileController::class, 'change_password'])->name('change_password');
    Route::post('change-password', [ProfileController::class, 'change_password_submit'])->name('change_password_submit');
    Route::get('edit', [ProfileController::class, 'edit'])->name('edit');
    Route::post('update', [ProfileController::class, 'update'])->name('update');
});

Route::prefix('admin')->middleware('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [IndexController::class, 'dashboard'])->name('dashboard');
    Route::resource('admin', AdminController::class);
    Route::resource('dictionary', DictionaryController::class);
    Route::resource('message', MessageController::class);
    Route::resource('user', UserController::class);
    Route::get('/user/{user}/change-password', [UserController::class, 'change_password'])->name('user.change_password');
    Route::post('/user/{user}/change-password', [UserController::class, 'change_password_submit'])->name('user.change_password_submit');
});
