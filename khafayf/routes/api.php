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

//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});
Route::group(['prefix' => 'v1'], function () {
    Route::post('/login', 'API\UserController@login');
    Route::post('/register', 'API\UserController@register');
    Route::post('/join_driver', 'API\UserController@join_drive');
    Route::post('/logout', 'API\UserController@logout')->middleware('auth:api');
    // Route::get('/getUser/{id}', 'API\UserController@getUser');
    // Route::get('/show/{id}', 'API\UserController@show');
    Route::post('/update', 'API\UserController@update')->middleware('auth:api');
    Route::post('/reset_password', 'API\UserController@reset_password')->middleware('auth:api');

    Route::post('/forget_password', 'Auth\ForgotPasswordController@getResetToken');
   
    //Craftat

   


    // Static App
    Route::get('/message_contact', 'API\AppController@get_setting');
    Route::post('/message_contact', 'API\AppController@message');
    Route::get('/aboutus', 'API\AppController@aboutus');
    Route::get('/privacy_policy', 'API\AppController@privacy_policy');
    Route::get('/terms_use', 'API\AppController@terms_use');
    Route::get('/settings', 'API\AppController@settings');
    
});