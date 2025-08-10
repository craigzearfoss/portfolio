<?php

use App\Http\Controllers\Admin\AdminController as AdminAdminController;
use App\Http\Controllers\Admin\CareerApplicationController as AdminApplicationController;
use App\Http\Controllers\Admin\PortfolioCertificateController as AdminCertificateController;
use App\Http\Controllers\Admin\CareerCommunicationController as AdminCommunicationController;
use App\Http\Controllers\Admin\CareerCompanyController as AdminCompanyController;
use App\Http\Controllers\Admin\CareerContactController as AdminContactController;
use App\Http\Controllers\Admin\CareerCoverLetterController as AdminCoverLetterController;
use App\Http\Controllers\Admin\IndexController as AdminIndexController;
use App\Http\Controllers\Admin\PortfolioLinkController as AdminLinkController;
use App\Http\Controllers\Admin\CareerNoteController as AdminNoteController;
use App\Http\Controllers\Admin\PortfolioProjectController as AdminProjectController;
use App\Http\Controllers\Admin\PortfolioReadingController as AdminReadingController;
use App\Http\Controllers\Admin\CareerResumeController as AdminResumeController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\PortfolioVideoController as AdminVideoController;
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
