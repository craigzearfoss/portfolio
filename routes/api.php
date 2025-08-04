<?php

use App\Http\Controllers\Admin\AdminController as AdminAdminController;
use App\Http\Controllers\Admin\ApplicationController as AdminApplicationController;
use App\Http\Controllers\Admin\CertificateController as AdminCertificateController;
use App\Http\Controllers\Admin\CommunicationController as AdminCommunicationController;
use App\Http\Controllers\Admin\CompanyController as AdminCompanyController;
use App\Http\Controllers\Admin\ContactController as AdminContactController;
use App\Http\Controllers\Admin\CoverLetterController as AdminCoverLetterController;
use App\Http\Controllers\Admin\IndexController as AdminIndexController;
use App\Http\Controllers\Admin\LinkController as AdminLinkController;
use App\Http\Controllers\Admin\NoteController as AdminNoteController;
use App\Http\Controllers\Admin\ProjectController as AdminProjectController;
use App\Http\Controllers\Admin\ReadingController as AdminReadingController;
use App\Http\Controllers\Admin\ResumeController as AdminResumeController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\VideoController as AdminVideoController;
use App\Http\Controllers\Front\FrontendController;
use App\Http\Controllers\Front\CertificateController as FrontCertificateController;
use App\Http\Controllers\Front\LinkController as FrontLinkController;
use App\Http\Controllers\Front\ProjectController as FrontProjectController;
use App\Http\Controllers\Front\ReadingController as FrontReadingController;
use App\Http\Controllers\Front\VideoController as FrontVideoController;
use App\Http\Controllers\User\UserController;
use App\Http\Resources\v1\UserCollection;
use App\Http\Resources\UserResource;
use App\Models\User;

use Illuminate\Support\Facades\Route;
/*
Route::prefix('api/v1/')->group(function () {
    Route::get('users', function () { return new  App\Http\Resources\UserCollection(User::all()); });
    Route::get('user/{id}', function (string $id) { return User::findOrFail($id)->toResource(); } );
    //Route::get('/users', function () { return UserResource::collection(User::all()); });
});
*/
