<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\Career\ApplicationController as CareerApplicationController;
use App\Http\Controllers\Admin\Career\CommunicationController as CareerCommunicationController;
use App\Http\Controllers\Admin\Career\CompanyController as CareerCompanyController;
use App\Http\Controllers\Admin\Career\ContactController as CareerContactController;
use App\Http\Controllers\Admin\Career\CoverLetterController as CareerCoverLetterController;
use App\Http\Controllers\Admin\Career\EventController as CareerEventController;
use App\Http\Controllers\Admin\Career\IndexController as CareerController;
use App\Http\Controllers\Admin\Career\IndustryController as CareerIndustryController;
use App\Http\Controllers\Admin\Career\JobBoardController as CareerJobBoardController;
use App\Http\Controllers\Admin\Career\NoteController as CareerNoteController;
use App\Http\Controllers\Admin\Career\ReferenceController as CareerReferenceController;
use App\Http\Controllers\Admin\Career\ResumeController as CareerResumeController;
use App\Http\Controllers\Admin\DatabaseController;
use App\Http\Controllers\Admin\Dictionary\CategoryController as DictionaryCategoryController;
use App\Http\Controllers\Admin\Dictionary\DatabaseController as DictionaryDatabaseController;
use App\Http\Controllers\Admin\Dictionary\FrameworkController as DictionaryFrameworkController;
use App\Http\Controllers\Admin\Dictionary\IndexController as DictionaryController;
use App\Http\Controllers\Admin\Dictionary\LanguageController as DictionaryLanguageController;
use App\Http\Controllers\Admin\Dictionary\LibraryController as DictionaryLibraryController;
use App\Http\Controllers\Admin\Dictionary\OperatingSystemController as DictionaryOperatingSystemController;
use App\Http\Controllers\Admin\Dictionary\ServerController as DictionaryServerController;
use App\Http\Controllers\Admin\Dictionary\StackController as DictionaryStackController;
use App\Http\Controllers\Admin\IndexController;
use App\Http\Controllers\Admin\MessageController;
use App\Http\Controllers\Admin\Personal\IngredientController as PortfolioIngredientController;
use App\Http\Controllers\Admin\Personal\ReadingController as PortfolioReadingController;
use App\Http\Controllers\Admin\Personal\RecipeController as PortfolioRecipeController;
use App\Http\Controllers\Admin\Personal\RecipeIngredientController as PortfolioRecipeIngredientController;
use App\Http\Controllers\Admin\Personal\RecipeStepController as PortfolioRecipeStepController;
use App\Http\Controllers\Admin\Personal\UnitController as PortfolioUnitController;
use App\Http\Controllers\Admin\Portfolio\AcademyController as PortfolioAcademyController;
use App\Http\Controllers\Admin\Portfolio\ArtController as PortfolioArtController;
use App\Http\Controllers\Admin\Portfolio\CertificationController as PortfolioCertificationController;
use App\Http\Controllers\Admin\Portfolio\CourseController as PortfolioCourseController;
use App\Http\Controllers\Admin\Portfolio\IndexController as PortfolioController;
use App\Http\Controllers\Admin\Portfolio\JobController as CareerJobController;
use App\Http\Controllers\Admin\Portfolio\JobCoworkerController as CareerJobCoworkerController;
use App\Http\Controllers\Admin\Portfolio\JobTaskController as CareerJobTaskController;
use App\Http\Controllers\Admin\Portfolio\LinkController as PortfolioLinkController;
use App\Http\Controllers\Admin\Portfolio\MusicController as PortfolioMusicController;
use App\Http\Controllers\Admin\Portfolio\ProjectController as PortfolioProjectController;
use App\Http\Controllers\Admin\Portfolio\SkillController as CareerSkillController;
use App\Http\Controllers\Admin\Portfolio\VideoController as PortfolioVideoController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\ResourceController;
use App\Http\Controllers\Admin\UserController;
use Illuminate\Support\Facades\Route;

Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [IndexController::class, 'index'])->name('index');
    Route::get('/login', [IndexController::class, 'login'])->name('login');
    Route::post('/login', [IndexController::class, 'login'])->name('login-submit');
    Route::get('/logout', [IndexController::class, 'logout'])->name('logout');
    Route::get('/forgot-password', [IndexController::class, 'forgot_password'])->name('forgot-password');
    Route::post('/forgot-password', [IndexController::class, 'forgot_password'])->name('forgot-password-submit');
    Route::get('/forgot-username', [IndexController::class, 'forgot_username'])->name('forgot-username');
    Route::post('/forgot-username', [IndexController::class, 'forgot_username'])->name('forgot-username-submit');
    Route::get('/reset-password/{token}/{email}', [IndexController::class, 'reset_password'])->name('reset-password');
    Route::post('/reset-password/{token}/{email}', [IndexController::class, 'reset_password_submit'])->name('reset-password-submit');
});

Route::prefix('admin/career')->middleware('admin')->name('admin.career.')->group(function () {
    Route::get('/', [CareerController::class, 'index'])->name('index');
    Route::resource('application', CareerApplicationController::class);
    Route::resource('communication', CareerCommunicationController::class);
    Route::resource('company', CareerCompanyController::class);
    Route::resource('contact', CareerContactController::class);
    Route::resource('cover-letter', CareerCoverLetterController::class)->parameter('cover-letter', 'cover_letter');
    Route::resource('industry', CareerIndustryController::class);
    Route::resource('event', CareerEventController::class);
    Route::resource('job', CareerJobController::class);
    Route::resource('job-coworker', CareerJobCoworkerController::class)->parameter('job-coworker', 'job_coworker');
    Route::resource('job-board', CareerJobBoardController::class)->parameter('job-board', 'job_board');
    Route::resource('job-task', CareerJobTaskController::class)->parameter('job-task', 'job-task');
    Route::resource('note', CareerNoteController::class);
    Route::resource('reference', CareerReferenceController::class);
    Route::resource('resume', CareerResumeController::class);
    Route::resource('skill', CareerSkillController::class);
});

Route::prefix('admin/dictionary')->middleware('admin')->name('admin.dictionary.')->group(function () {
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

Route::prefix('admin/portfolio')->middleware('admin')->name('admin.portfolio.')->group(function () {
    Route::get('/', [PortfolioController::class, 'index'])->name('index');
    Route::resource('academy', PortfolioAcademyController::class);
    Route::resource('art', PortfolioArtController::class);
    Route::resource('certification', PortfolioCertificationController::class);
    Route::resource('course', PortfolioCourseController::class);
    Route::resource('ingredient', PortfolioIngredientController::class);
    Route::resource('link', PortfolioLinkController::class);
    Route::resource('music', PortfolioMusicController::class);
    Route::resource('project', PortfolioProjectController::class);
    Route::resource('reading', PortfolioReadingController::class);
    Route::resource('recipe', PortfolioRecipeController::class);
    Route::resource('recipe-ingredient', PortfolioRecipeIngredientController::class)->parameter('recipe-ingredient', 'recipe_ingredient');
    Route::resource('recipe-step', PortfolioRecipeStepController::class)->parameter('recipe-step', 'recipe_step');
    Route::resource('unit', PortfolioUnitController::class);
    Route::resource('video', PortfolioVideoController::class);
});

Route::prefix('admin/profile')->middleware('admin')->name('admin.profile.')->group(function () {
    Route::get('/', [ProfileController::class, 'show'])->name('show');
    Route::get('change-password', [ProfileController::class, 'change_password'])->name('change-password');
    Route::post('change-password', [ProfileController::class, 'change_password_submit'])->name('change-password-submit');
    Route::get('edit', [ProfileController::class, 'edit'])->name('edit');
    Route::post('update', [ProfileController::class, 'update'])->name('update');
});

Route::prefix('admin')->middleware('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [IndexController::class, 'dashboard'])->name('dashboard');
    Route::resource('admin', AdminController::class);
    Route::resource('database', DatabaseController::class);
    Route::resource('dictionary', DictionaryController::class);
    Route::resource('message', MessageController::class);
    Route::resource('resource', ResourceController::class);
    Route::resource('user', UserController::class);
    Route::get('/user/{user}/change-password', [UserController::class, 'change_password'])->name('user.change-password');
    Route::post('/user/{user}/change-password', [UserController::class, 'change_password_submit'])->name('user.change-password-submit');
});
