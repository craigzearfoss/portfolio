<?php


use App\Http\Resources\V1\CompanyCollection;
use App\Http\Resources\V1\StateResource;
use App\Http\Resources\V1\UserResource;
use App\Models\Career\Company;
use App\Models\System\State;
use App\Models\System\User;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {

    Route::get('/companies', function () {return new CompanyCollection(Company::paginate()); });
    Route::get('/companies/list', function () {return new CompanyCollection(Company::listOptions()); });

    Route::get('/states', function () { dd( StateResource::collection(State::all())); return StateResource::collection(State::all()); });
    Route::get('/state/{codeOrId}', function (string $codeOrId) {
        if (is_numeric($codeOrId)) {
            return new StateResource(new State()->findOrFail($codeOrId));
        } else {
            return new StateResource(State::findStateByCode($codeOrId));
        }
    });
});


Route::prefix('v1')->group(function () {
    Route::get('/user/{id}', function (string $id) {
        return new UserResource(new User()->findOrFail($id));
        //return User::findOrFail($id)->toResource();
    });
    Route::get('/users', function () {
        //return UserResource::collection(User::all());
        //return new UserCollection(User::all());
        return UserResource::collection(User::all()->keyBy->id);
    });
});
/*
Route::prefix('v1')->group(function () {
    //Route::get('users', function () { return new  UserResource(User::findOrFail($id));}
    Route::get('/user/{id}', function (string $id) { return new  UserResource(User::findOrFail($id)); }
});
    */

/*
Route::prefix('v1')->group(function () {
    Route::get('users', function () { return new  App\Http\Resources\UserCollection(User::all()); });
    Route::get('user/{id}', function (string $id) { return User::findOrFail($id)->toResource(); } );
//    Route::get('/user', function (Request $request) {
//        return $request->user();
//    });//->middleware('auth:api');
});
*/

/*
Route::prefix('api/v1/')->group(function () {
    Route::get('users', function () { return new  App\Http\Resources\UserCollection(User::all()); });
    Route::get('user/{id}', function (string $id) { return User::findOrFail($id)->toResource(); } );
    //Route::get('/users', function () { return UserResource::collection(User::all()); });
});*/
