<?php

use App\Http\Controllers\Admin\Career\ApplicationController as AdminCareerApplicationController;
use App\Http\Controllers\Admin\Career\ApplicationSkillController as AdminCareerApplicationSkillController;
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

use App\Http\Controllers\Admin\Root\Career\ApplicationController as AdminRootCareerApplicationController;
use App\Http\Controllers\Admin\Root\Career\ApplicationSkillController as AdminRootCareerApplicationSkillController;
use App\Http\Controllers\Admin\Root\Career\CommunicationController as AdminRootCareerCommunicationController;
use App\Http\Controllers\Admin\Root\Career\CompanyController as AdminRootCareerCompanyController;
use App\Http\Controllers\Admin\Root\Career\ContactController as AdminRootCareerContactController;
use App\Http\Controllers\Admin\Root\Career\CoverLetterController as AdminRootCareerCoverLetterController;
use App\Http\Controllers\Admin\Root\Career\EventController as AdminRootCareerEventController;
use App\Http\Controllers\Admin\Root\Career\IndexController as AdminRootCareerIndexController;
use App\Http\Controllers\Admin\Root\Career\IndustryController as AdminRootCareerIndustryController;
use App\Http\Controllers\Admin\Root\Career\JobBoardController as AdminRootCareerJobBoardController;
use App\Http\Controllers\Admin\Root\Career\NoteController as AdminRootCareerNoteController;
use App\Http\Controllers\Admin\Root\Career\RecruiterController as AdminRootCareerRecruiterController;
use App\Http\Controllers\Admin\Root\Career\ReferenceController as AdminRootCareerReferenceController;
use App\Http\Controllers\Admin\Root\Career\ResumeController as AdminRootCareerResumeController;

use Illuminate\Support\Facades\Route;

Route::prefix('admin/career')->middleware('admin')->name('admin.career.')->group(function () {

    Route::get('/', [AdminCareerIndexController::class, 'index'])->name('index');

    Route::resource('industry', AdminCareerIndustryController::class);
    Route::resource('job-board', AdminCareerJobBoardController::class)->parameter('job-board', 'job_board');
    Route::resource('recruiter', AdminCareerRecruiterController::class);

    Route::resource('application', AdminCareerApplicationController::class);
    Route::resource('application/skill', AdminCareerApplicationSkillController::class);
    Route::resource('communication', AdminCareerCommunicationController::class);
    Route::resource('company', AdminCareerCompanyController::class);
    Route::get('company/{company}/contact/add', [AdminCareerCompanyController::class, 'addContact'])->name('company.contact.add');
    Route::post('company/{company}/contact/attach', [AdminCareerCompanyController::class, 'attachContact'])->name('company.contact.attach');
    Route::delete('company/{company}/contact/detach/{contact}', [AdminCareerCompanyController::class, 'detachContact'])->name('company.contact.detach');
    Route::resource('contact', AdminCareerContactController::class);
    Route::get('contact/{contact}/company/add', [AdminCareerContactController::class, 'addCompany'])->name('contact.company.add');
    Route::post('contact/{contact}/company/attach', [AdminCareerContactController::class, 'attachCompany'])->name('contact.company.attach');
    Route::delete('contact/{contact}/company/detach/{company}', [AdminCareerContactController::class, 'detachCompany'])->name('contact.company.detach');
    Route::resource('cover-letter', AdminCareerCoverLetterController::class)->parameter('cover-letter', 'cover_letter');
    Route::resource('event', AdminCareerEventController::class);
    Route::resource('note', AdminCareerNoteController::class);
    Route::resource('reference', AdminCareerReferenceController::class);
    Route::resource('resume', AdminCareerResumeController::class);
});

// Routes for an admin viewing career resources of another admin. These routes are only used by admins.
Route::prefix('admin/admin')->middleware('admin')->name('root.career.')->group(function () {

    Route::get('career', [AdminRootCareerIndexController::class, 'index'])->name('index');

    Route::resource('career/industry', AdminRootCareerIndustryController::class);
    Route::resource('career/job-board', AdminRootCareerJobBoardController::class)->parameter('job-board', 'job_board');
    Route::resource('career/recruiter', AdminRootCareerRecruiterController::class);

    Route::resource('{admin:id}/application', AdminRootCareerApplicationController::class);
    Route::resource('{admin:id}/career/application-skill', AdminRootCareerApplicationSkillController::class);
    Route::resource('{admin:id}/career/communication', AdminRootCareerCommunicationController::class);
    Route::resource('{admin:id}/career/company', AdminRootCareerCompanyController::class);

    Route::get('{admin:id}/career/company/{company}/contact/add', [AdminRootCareerCompanyController::class, 'addContact'])->name('company.add-contact');
    Route::post('{admin:id}/career/company/{company}/contact/attach', [AdminRootCareerCompanyController::class, 'attachContact'])->name('company.contact.attach-contact');
    Route::delete('{admin:id}/career/company/{company}/contact/detach/{contact}', [AdminRootCareerCompanyController::class, 'detachContact'])->name('company.detach-contact');

    Route::resource('{admin:id}/contact', AdminRootCareerContactController::class);
    Route::get('{admin:id}/career/contact/{contact}/company/add', [AdminRootCareerContactController::class, 'addCompany'])->name('contact.add-company');
    Route::post('{admin:id}/career/contact/{contact}/company/attach', [AdminRootCareerContactController::class, 'attachCompany'])->name('contact.attach-company');
    Route::delete('{admin:id}/career/contact/{contact}/company/detach/{company}', [AdminRootCareerContactController::class, 'detachCompany'])->name('contact.detach-company');

    Route::resource('cover-letter', AdminRootCareerCoverLetterController::class)->parameter('cover-letter', 'cover_letter');
    Route::resource('{admin:id}/event', AdminRootCareerEventController::class);
    Route::resource('{admin:id}/note', AdminRootCareerNoteController::class);
    Route::resource('{admin:id}/reference', AdminRootCareerReferenceController::class);
    Route::resource('{admin:id}/resume', AdminRootCareerResumeController::class);
});
