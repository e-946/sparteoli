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

Auth::routes(['verify' => false, 'reset' => false]);

Route::get('/home', 'HomeController@index')->name('home');

Route::group(['middleware' => ['auth']], function (){
    Route::group(['middleware' => ['can:admin']], function (){
        Route::prefix('nature')->group(function () {
            Route::get('/create', 'NatureController@create')->name('create-nature');
            Route::post('/create', 'NatureController@store')->name('store-nature');
            Route::delete('/{id}', 'NatureController@destroy')->name('destroy-nature')->where('id', '[0-9]+');
            Route::get('/{id}/update', 'NatureController@edit')->name('edit-nature')->where('id', '[0-9]+');
            Route::put('/{id}/update', 'NatureController@update')->name('update-nature')->where('id', '[0-9]+');
        });
        Route::prefix('type')->group(function () {
            Route::get('/create', 'TypeController@create')->name('create-type');
            Route::post('/create', 'TypeController@store')->name('store-type');
            Route::delete('/{id}', 'TypeController@destroy')->name('destroy-type')->where('id', '[0-9]+');
            Route::get('/{id}/update', 'TypeController@edit')->name('edit-type')->where('id', '[0-9]+');
            Route::put('/{id}/update', 'TypeController@update')->name('update-type')->where('id', '[0-9]+');
        });
        Route::prefix('fireprotection')->group(function () {
            Route::get('/create', 'FireprotectionController@create')->name('create-fireprotection');
            Route::post('/create', 'FireprotectionController@store')->name('store-fireprotection');
            Route::delete('/{id}', 'FireprotectionController@destroy')->name('destroy-fireprotection')->where('id', '[0-9]+');
            Route::get('/{id}/update', 'FireprotectionController@edit')->name('edit-fireprotection')->where('id', '[0-9]+');
            Route::put('/{id}/update', 'FireprotectionController@update')->name('update-fireprotection')->where('id', '[0-9]+');
        });
        Route::prefix('rescuer')->group(function () {
            Route::get('/create', 'RescuerController@create')->name('create-rescuer');
            Route::post('/create', 'RescuerController@store')->name('store-rescuer');
            Route::delete('/{id}', 'RescuerController@destroy')->name('destroy-rescuer')->where('id', '[0-9]+');
            Route::get('/{id}/update', 'RescuerController@edit')->name('edit-rescuer')->where('id', '[0-9]+');
            Route::put('/{id}/update', 'RescuerController@update')->name('update-rescuer')->where('id', '[0-9]+');
        });
        Route::prefix('problem')->group(function () {
            Route::get('/create', 'ProblemController@create')->name('create-problem');
            Route::post('/create', 'ProblemController@store')->name('store-problem');
            Route::delete('/{id}', 'ProblemController@destroy')->name('destroy-problem')->where('id', '[0-9]+');
            Route::get('/{id}/update', 'ProblemController@edit')->name('edit-problem')->where('id', '[0-9]+');
            Route::put('/{id}/update', 'ProblemController@update')->name('update-problem')->where('id', '[0-9]+');
        });
        Route::prefix('placefreature')->group(function () {
            Route::get('/create', 'PlacefreatureController@create')->name('create-placefreature');
            Route::post('/create', 'PlacefreatureController@store')->name('store-placefreature');
            Route::delete('/{id}', 'PlacefreatureController@destroy')->name('destroy-placefreature')->where('id', '[0-9]+');
            Route::get('/{id}/update', 'PlacefreatureController@edit')->name('edit-placefreature')->where('id', '[0-9]+');
            Route::put('/{id}/update', 'PlacefreatureController@update')->name('update-placefreature')->where('id', '[0-9]+');
        });
        Route::prefix('meanused')->group(function () {
            Route::get('/create', 'MeanusedController@create')->name('create-meanused');
            Route::post('/create', 'MeanusedController@store')->name('store-meanused');
            Route::delete('/{id}', 'MeanusedController@destroy')->name('destroy-meanused')->where('id', '[0-9]+');
            Route::get('/{id}/update', 'MeanusedController@edit')->name('edit-meanused')->where('id', '[0-9]+');
            Route::put('/{id}/update', 'MeanusedController@update')->name('update-meanused')->where('id', '[0-9]+');
        });
        Route::prefix('placeuse')->group(function () {
            Route::get('/create', 'PlaceuseController@create')->name('create-placeuse');
            Route::post('/create', 'PlaceuseController@store')->name('store-placeuse');
            Route::delete('/{id}', 'PlaceuseController@destroy')->name('destroy-placeuse')->where('id', '[0-9]+');
            Route::get('/{id}/update', 'PlaceuseController@edit')->name('edit-placeuse')->where('id', '[0-9]+');
            Route::put('/{id}/update', 'PlaceuseController@update')->name('update-placeuse')->where('id', '[0-9]+');
        });
        Route::prefix('user')->group(function () {
            Route::delete('/{id}', 'UserController@destroy')->name('destroy-user')->where('id', '[0-9]+');
            Route::get('/', 'UserController@index')->name('index-user');
        });
        Route::get('profile/password/{id}', 'UserController@changePasswordID')->name('passwordId')->where('id', '[0-9]+');
    });
    Route::prefix('nature')->group(function () {
        Route::get('/', 'NatureController@index')->name('index-nature');
        Route::get('/{id}', 'NatureController@show')->name('show-nature')->where('id', '[0-9]+');
    });

    Route::prefix('type')->group(function () {
        Route::get('/', 'TypeController@index')->name('index-type');
        Route::get('/{id}', 'TypeController@show')->name('show-type')->where('id', '[0-9]+');
    });

    Route::prefix('fireprotection')->group(function () {
        Route::get('/', 'FireprotectionController@index')->name('index-fireprotection');
        Route::get('/{id}', 'FireprotectionController@show')->name('show-fireprotection')->where('id', '[0-9]+');
    });

    Route::prefix('rescuer')->group(function () {
        Route::get('/', 'RescuerController@index')->name('index-rescuer');
    });

    Route::prefix('problem')->group(function () {
        Route::get('/', 'ProblemController@index')->name('index-problem');
        Route::get('/{id}', 'ProblemController@show')->name('show-problem')->where('id', '[0-9]+');
    });
    Route::prefix('placefreature')->group(function () {
        Route::get('/', 'PlacefreatureController@index')->name('index-placefreature');
    });
    Route::prefix('meanused')->group(function () {
        Route::get('/', 'MeanusedController@index')->name('index-meanused');
    });
    Route::prefix('placeuse')->group(function () {
        Route::get('/', 'PlaceuseController@index')->name('index-placeuse');
    });

    Route::prefix('user')->group(function () {
        Route::get('/{id}', 'UserController@show')->name('show-user')->where('id', '[0-9]+');
        Route::get('/{id}/update', 'UserController@edit')->name('edit-user')->where('id', '[0-9]+');
        Route::put('/{id}/update', 'UserController@update')->name('update-user')->where('id', '[0-9]+');
    });

    Route::prefix('occurrence')->group(function () {
        Route::get('/', 'OccurrenceController@index')->name('index-occurrence');
        Route::get('/{id}', 'OccurrenceController@show')->name('show-occurrence')->where('id', '[0-9]+');
        Route::get('/{id}/pdf', 'OccurrenceController@toPdf')->name('toPdf-occurrence')->where('id', '[0-9]+');


        Route::prefix('{occurrence_id}/victim')->where(['occurrence_id' => '[0-9]+'])->group(function () {
            Route::get('/', 'VictimController@index')->name('index-victim');
            Route::get('/{id}', 'VictimController@show')->name('show-victim')->where('id', '[0-9]+');
            Route::get('/create', 'VictimController@create')->name('create-victim');
            Route::post('/create', 'VictimController@store')->name('store-victim');
            Route::delete('/{id}', 'VictimController@destroy')->name('destroy-victim')->where('id', '[0-9]+');
            Route::get('/{id}/update', 'VictimController@edit')->name('edit-victim')->where('id', '[0-9]+');
            Route::put('/{id}/update', 'VictimController@update')->name('update-victim')->where('id', '[0-9]+');
        });

        Route::prefix('{occurrence_id}/resource')->where(['occurrence_id' => '[0-9]+'])->group(function () {
            Route::get('/', 'ResourceController@index')->name('index-resource');
            Route::get('/{id}', 'ResourceController@show')->name('show-resource')->where('id', '[0-9]+');
            Route::get('/create', 'ResourceController@create')->name('create-resource');
            Route::post('/create', 'ResourceController@store')->name('store-resource');
            Route::delete('/{id}', 'ResourceController@destroy')->name('destroy-resource')->where('id', '[0-9]+');
            Route::get('/{id}/update', 'ResourceController@edit')->name('edit-resource')->where('id', '[0-9]+');
            Route::put('/{id}/update', 'ResourceController@update')->name('update-resource')->where('id', '[0-9]+');
        });

        Route::get('/create', 'OccurrenceController@create')->name('create-occurrence');
        Route::post('/create', 'OccurrenceController@store')->name('store-occurrence');
        Route::delete('/{id}', 'OccurrenceController@destroy')->name('destroy-occurrence')->where('id', '[0-9]+');
        Route::get('/{id}/update', 'OccurrenceController@edit')->name('edit-occurrence')->where('id', '[0-9]+');
        Route::put('/{id}/update', 'OccurrenceController@update')->name('update-occurrence')->where('id', '[0-9]+');
    });

    Route::get('profile', 'UserController@profile')->name('profile');
    Route::get('profile/password', 'UserController@changePassword')->name('password');
    Route::put('profile/password/{id}', 'UserController@storePassword')->name('password-store')->where('id', '[0-9]+');
});
