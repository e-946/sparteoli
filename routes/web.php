<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::group(['middleware' => ['auth']], function (){
    Route::group(['middleware' => ['can:admin']], function (){
        Route::prefix('nature')->group(function () {
            Route::get('/create', 'NatureController@create')->name('create-nature');
            Route::post('/create', 'NatureController@store')->name('store-nature');
            Route::delete('/{id}', 'NatureController@destroy')->name('destroy-nature');
            Route::get('/{id}/update', 'NatureController@edit')->name('edit-nature');
            Route::put('/{id}/update', 'NatureController@update')->name('update-nature');
        });
        Route::prefix('type')->group(function () {
            Route::get('/create', 'TypeController@create')->name('create-type');
            Route::post('/create', 'TypeController@store')->name('store-type');
            Route::delete('/{id}', 'TypeController@destroy')->name('destroy-type');
            Route::get('/{id}/update', 'TypeController@edit')->name('edit-type');
            Route::put('/{id}/update', 'TypeController@update')->name('update-type');
        });
        Route::prefix('fireprotection')->group(function () {
            Route::get('/create', 'FireprotectionController@create')->name('create-fireprotection');
            Route::post('/create', 'FireprotectionController@store')->name('store-fireprotection');
            Route::delete('/{id}', 'FireprotectionController@destroy')->name('destroy-fireprotection');
            Route::get('/{id}/update', 'FireprotectionController@edit')->name('edit-fireprotection');
            Route::put('/{id}/update', 'FireprotectionController@update')->name('update-fireprotection');
        });
        Route::prefix('rescuer')->group(function () {
            Route::get('/create', 'RescuerController@create')->name('create-rescuer');
            Route::post('/create', 'RescuerController@store')->name('store-rescuer');
            Route::delete('/{id}', 'RescuerController@destroy')->name('destroy-rescuer');
            Route::get('/{id}/update', 'RescuerController@edit')->name('edit-rescuer');
            Route::put('/{id}/update', 'RescuerController@update')->name('update-rescuer');
        });
        Route::prefix('problem')->group(function () {
            Route::get('/create', 'ProblemController@create')->name('create-problem');
            Route::post('/create', 'ProblemController@store')->name('store-problem');
            Route::delete('/{id}', 'ProblemController@destroy')->name('destroy-problem');
            Route::get('/{id}/update', 'ProblemController@edit')->name('edit-problem');
            Route::put('/{id}/update', 'ProblemController@update')->name('update-problem');
        });
        Route::prefix('placefreature')->group(function () {
            Route::get('/create', 'PlacefreatureController@create')->name('create-placefreature');
            Route::post('/create', 'PlacefreatureController@store')->name('store-placefreature');
            Route::delete('/{id}', 'PlacefreatureController@destroy')->name('destroy-placefreature');
            Route::get('/{id}/update', 'PlacefreatureController@edit')->name('edit-placefreature');
            Route::put('/{id}/update', 'PlacefreatureController@update')->name('update-placefreature');
        });
        Route::prefix('meanused')->group(function () {
            Route::get('/create', 'MeanusedController@create')->name('create-meanused');
            Route::post('/create', 'MeanusedController@store')->name('store-meanused');
            Route::delete('/{id}', 'MeanusedController@destroy')->name('destroy-meanused');
            Route::get('/{id}/update', 'MeanusedController@edit')->name('edit-meanused');
            Route::put('/{id}/update', 'MeanusedController@update')->name('update-meanused');
        });
        Route::prefix('placeuse')->group(function () {
            Route::get('/create', 'PlaceuseController@create')->name('create-placeuse');
            Route::post('/create', 'PlaceuseController@store')->name('store-placeuse');
            Route::delete('/{id}', 'PlaceuseController@destroy')->name('destroy-placeuse');
            Route::get('/{id}/update', 'PlaceuseController@edit')->name('edit-placeuse');
            Route::put('/{id}/update', 'PlaceuseController@update')->name('update-placeuse');
        });
        Route::prefix('user')->group(function () {
            Route::delete('/{id}', 'UserController@destroy')->name('destroy-user');
            Route::get('/', 'UserController@index')->name('index-user');
        });
        Route::get('profile/password/{id}', 'UserController@changePasswordID')->name('passwordId');
    });
    Route::prefix('nature')->group(function () {
        Route::get('/', 'NatureController@index')->name('index-nature');
        Route::get('/{id}', 'NatureController@show')->name('show-nature');
    });

    Route::prefix('type')->group(function () {
        Route::get('/', 'TypeController@index')->name('index-type');
        Route::get('/{id}', 'TypeController@show')->name('show-type');

    });

    Route::prefix('fireprotection')->group(function () {
        Route::get('/', 'FireprotectionController@index')->name('index-fireprotection');
        Route::get('/{id}', 'FireprotectionController@show')->name('show-fireprotection');
    });

    Route::prefix('rescuer')->group(function () {
        Route::get('/', 'RescuerController@index')->name('index-rescuer');
        Route::get('/{id}', 'RescuerController@show')->name('show-rescuer');
    });

    Route::prefix('problem')->group(function () {
        Route::get('/', 'ProblemController@index')->name('index-problem');
        Route::get('/{id}', 'ProblemController@show')->name('show-problem');
    });
    Route::prefix('placefreature')->group(function () {
        Route::get('/', 'PlacefreatureController@index')->name('index-placefreature');
        Route::get('/{id}', 'PlacefreatureController@show')->name('show-placefreature');
    });
    Route::prefix('meanused')->group(function () {
        Route::get('/', 'MeanusedController@index')->name('index-meanused');
        Route::get('/{id}', 'MeanusedController@show')->name('show-meanused');
    });
    Route::prefix('placeuse')->group(function () {
        Route::get('/', 'PlaceuseController@index')->name('index-placeuse');
        Route::get('/{id}', 'PlaceuseController@show')->name('show-placeuse');
    });

    Route::prefix('user')->group(function () {
        Route::get('/{id}', 'UserController@show')->name('show-user');
        Route::get('/{id}/update', 'UserController@edit')->name('edit-user');
        Route::put('/{id}/update', 'UserController@update')->name('update-user');
    });

    Route::get('profile', 'UserController@profile')->name('profile');
    Route::get('profile/password', 'UserController@changePassword')->name('password');
    Route::put('profile/password/{id}', 'UserController@storePassword')->name('password-store');
});
