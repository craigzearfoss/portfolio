<?php

use App\Http\Controllers\Front\CertificateController as FrontCertificateController;
use App\Http\Controllers\Front\FrontendController;
use App\Http\Controllers\User\UserController;
/*
Route::prefix('api/v1/')->group(function () {
    Route::get('users', function () { return new  App\Http\Resources\UserCollection(User::all()); });
    Route::get('user/{id}', function (string $id) { return User::findOrFail($id)->toResource(); } );
    //Route::get('/users', function () { return UserResource::collection(User::all()); });
});
*/
