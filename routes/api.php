<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::apiResources(['users' => 'API\UserController']);
Route::get('/findUser','API\UserController@search')->name('user.findUser');
Route::get('/profile','API\UserController@profile')->name('user.profile');
Route::put('/profile','API\UserController@updateProfile')->name('user.updateProfile');

