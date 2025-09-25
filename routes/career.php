<?php

use App\Http\Controllers\Admin\Career\ApplicationController as AdminCareerApplicationController;
use App\Http\Controllers\Admin\Career\CommunicationController as AdminCareerCommunicationController;
use App\Http\Controllers\Admin\Career\CompanyController as AdminCareerCompanyController;
use App\Http\Controllers\Admin\Career\ContactController as AdminCareerContactController;
use App\Http\Controllers\Admin\Career\CoverLetterController as AdminCareerCoverLetterController;
use App\Http\Controllers\Admin\Career\EventController as AdminCareerEventController;
use App\Http\Controllers\Admin\Career\IndexController as AdminCareerIndexController;
use App\Http\Controllers\Admin\Career\IndustryController as AdminCareerIndustryController;
use App\Http\Controllers\Admin\Career\JobBoardController as AdminCareerJobBoardController;
use App\Http\Controllers\Admin\Career\NoteController as AdminCareerNoteController;
use App\Http\Controllers\Admin\Career\RecruiterController as AdminCareerRecruiterController;
use App\Http\Controllers\Admin\Career\ReferenceController as AdminCareerReferenceController;
use App\Http\Controllers\Admin\Career\ResumeController as AdminCareerResumeController;

use Illuminate\Support\Facades\Route;

Route::prefix('admin/career')->middleware('admin')->name('admin.career.')->group(function () {
    Route::get('/', [AdminCareerIndexController::class, 'index'])->name('index');
    Route::resource('application', AdminCareerApplicationController::class);
    Route::resource('communication', AdminCareerCommunicationController::class);
    Route::resource('company', AdminCareerCompanyController::class);
    Route::resource('contact', AdminCareerContactController::class);
    Route::resource('cover-letter', AdminCareerCoverLetterController::class)->parameter('cover-letter', 'cover_letter');
    Route::resource('industry', AdminCareerIndustryController::class);
    Route::resource('event', AdminCareerEventController::class);
    Route::resource('job-board', AdminCareerJobBoardController::class)->parameter('job-board', 'job_board');
    Route::resource('note', AdminCareerNoteController::class);
    Route::resource('recruiter', AdminCareerRecruiterController::class);
    Route::resource('reference', AdminCareerReferenceController::class);
    Route::resource('resume', AdminCareerResumeController::class);
});
