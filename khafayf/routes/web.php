<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::group([
    'prefix' => LaravelLocalization::setLocale(),
    'middleware' => [
        'localeSessionRedirect',
        'localizationRedirect',
        'localeViewPath'
    ]
], function () {
    /** ADD ALL LOCALIZED ROUTES INSIDE THIS GROUP **/
    Route::get('/', 'WEB\User\HomeController@index')->name('home');
//    Route::get('/home', 'WEB\User\HomeController@index')->name('home');
    Route::get('/home', function () {
        return redirect('/');
    })->name('home-page');

    
    
   
    

    Auth::routes();

 

    Route::group(['prefix' => 'admin'], function () {
        Route::get('/login', 'AdminAuth\LoginController@showLoginForm')->name('admin.login.form');
        Route::post('/login', 'AdminAuth\LoginController@login')->name('admin.login');
        Route::post('/logout', 'AdminAuth\LoginController@logout')->name('logout')->name('admin.logout');
    });







    Route::group(['middleware' => ['web', 'admin', 'auth:admin'], 'prefix' => 'admin', 'as' => 'admin.',], function () {
        Route::get('/', function () {
            return redirect('/admin/home');
        });

        Route::get('home', 'WEB\Admin\HomeController@index')->name('admin.home');
        // change document admin -cpanel
        Route::get('profile', 'WEB\Admin\HomeController@profile')->name('admin.profile');
        Route::post('profile', 'WEB\Admin\HomeController@update')->name('admin.update');
        Route::post('update_password', 'WEB\Admin\HomeController@update_password')->name('admin.update_password');

        Route::get('settings', 'WEB\Admin\SettingController@index')->name('settings.index');
        Route::post('settings', 'WEB\Admin\SettingController@update')->name('settings.update');
        Route::resource('pages', 'WEB\Admin\PageController', ['except' => ['update']]);
        Route::post('pages/{id}', 'WEB\Admin\PageController@update');

        Route::get('/users', 'WEB\Admin\UserController@index')->name('users.all');
        Route::post('/users', 'WEB\Admin\UserController@store')->name('users.store');
        Route::get('/users/create', 'WEB\Admin\UserController@create')->name('users.create')->middleware('auth');
        Route::delete('users/{id}', 'WEB\Admin\UserController@destroy')->name('users.destroy');
        Route::get('/users/{id}/edit', 'WEB\Admin\UserController@edit')->name('users.edit');
        Route::post('/users/{id}', 'WEB\Admin\UserController@update')->name('users.update');

        // change password for user
        // Route::get('/users/{id}/edit_password', 'WEB\Admin\UserController@edit_password')->name('users.edit_password');
        // Route::post('/users/{id}/edit_password', 'WEB\Admin\UserController@update_password')->name('users.edit_password');


        Route::get('/driver_man', 'WEB\Admin\DriverController@index')->name('driver_man.all');
        Route::delete('driver_man/{id}', 'WEB\Admin\DriverController@destroy')->name('driver_man.destroy');
        Route::get('/driver_man/{id}/edit', 'WEB\Admin\DriverController@edit')->name('driver_man.edit');
        Route::post('/driver_man/{id}', 'WEB\Admin\DriverController@update')->name('driver_man.update');
        Route::get('/driver_man/{id}/edit_password', 'WEB\Admin\DriverController@edit_password')->name('driver_man.edit_password');
        Route::post('/driver_man/{id}/edit_password', 'WEB\Admin\DriverController@update_password')->name('driver_man.edit_password');


       
    });
});