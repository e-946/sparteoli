<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\FireprotectionController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MeanusedController;
use App\Http\Controllers\NatureController;
use App\Http\Controllers\OccurrenceController;
use App\Http\Controllers\PlacefreatureController;
use App\Http\Controllers\PlaceuseController;
use App\Http\Controllers\ProblemController;
use App\Http\Controllers\RescuerController;
use App\Http\Controllers\ResourceController;
use App\Http\Controllers\TypeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VictimController;
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

Route::get('/home', [HomeController::class, 'index'])->name('home');

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);

Route::group(['middleware' => ['auth']], function (){

    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

    Route::group(['middleware' => ['can:admin']], function (){

        Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
        Route::post('/register', [RegisterController::class, 'register']);

        Route::prefix('nature')->group(function () {
            Route::get('/create', [NatureController::class, 'create'])->name('create-nature');
            Route::post('/create', [NatureController::class, 'store'])->name('store-nature');
            Route::delete('/{id}', [NatureController::class, 'destroy'])->name('destroy-nature')->where('id', '[0-9]+');
            Route::get('/{id}/update', [NatureController::class, 'edit'])->name('edit-nature')->where('id', '[0-9]+');
            Route::put('/{id}/update', [NatureController::class, 'update'])->name('update-nature')->where('id', '[0-9]+');
        });
        Route::prefix('type')->group(function () {
            Route::get('/create', [TypeController::class, 'create'])->name('create-type');
            Route::post('/create', [TypeController::class, 'store'])->name('store-type');
            Route::delete('/{id}', [TypeController::class, 'destroy'])->name('destroy-type')->where('id', '[0-9]+');
            Route::get('/{id}/update', [TypeController::class, 'edit'])->name('edit-type')->where('id', '[0-9]+');
            Route::put('/{id}/update', [TypeController::class, 'update'])->name('update-type')->where('id', '[0-9]+');
        });
        Route::prefix('fireprotection')->group(function () {
            Route::get('/create', [FireprotectionController::class, 'create'])->name('create-fireprotection');
            Route::post('/create', [FireprotectionController::class, 'store'])->name('store-fireprotection');
            Route::delete('/{id}', [FireprotectionController::class, 'destroy'])->name('destroy-fireprotection')->where('id', '[0-9]+');
            Route::get('/{id}/update', [FireprotectionController::class, 'edit'])->name('edit-fireprotection')->where('id', '[0-9]+');
            Route::put('/{id}/update', [FireprotectionController::class, 'update'])->name('update-fireprotection')->where('id', '[0-9]+');
        });
        Route::prefix('rescuer')->group(function () {
            Route::get('/create', [RescuerController::class, 'create'])->name('create-rescuer');
            Route::post('/create', [RescuerController::class, 'store'])->name('store-rescuer');
            Route::delete('/{id}', [RescuerController::class, 'destroy'])->name('destroy-rescuer')->where('id', '[0-9]+');
            Route::get('/{id}/update', [RescuerController::class, 'edit'])->name('edit-rescuer')->where('id', '[0-9]+');
            Route::put('/{id}/update', [RescuerController::class, 'update'])->name('update-rescuer')->where('id', '[0-9]+');
        });
        Route::prefix('problem')->group(function () {
            Route::get('/create', [ProblemController::class, 'create'])->name('create-problem');
            Route::post('/create', [ProblemController::class, 'store'])->name('store-problem');
            Route::delete('/{id}', [ProblemController::class, 'destroy'])->name('destroy-problem')->where('id', '[0-9]+');
            Route::get('/{id}/update', [ProblemController::class, 'edit'])->name('edit-problem')->where('id', '[0-9]+');
            Route::put('/{id}/update', [ProblemController::class, 'update'])->name('update-problem')->where('id', '[0-9]+');
        });
        Route::prefix('placefreature')->group(function () {
            Route::get('/create', [PlacefreatureController::class, 'create'])->name('create-placefreature');
            Route::post('/create', [PlacefreatureController::class, 'store'])->name('store-placefreature');
            Route::delete('/{id}', [PlacefreatureController::class, 'destroy'])->name('destroy-placefreature')->where('id', '[0-9]+');
            Route::get('/{id}/update', [PlacefreatureController::class, 'edit'])->name('edit-placefreature')->where('id', '[0-9]+');
            Route::put('/{id}/update', [PlacefreatureController::class, 'update'])->name('update-placefreature')->where('id', '[0-9]+');
        });
        Route::prefix('meanused')->group(function () {
            Route::get('/create', [MeanusedController::class, 'create'])->name('create-meanused');
            Route::post('/create', [MeanusedController::class, 'store'])->name('store-meanused');
            Route::delete('/{id}', [MeanusedController::class, 'destroy'])->name('destroy-meanused')->where('id', '[0-9]+');
            Route::get('/{id}/update', [MeanusedController::class, 'edit'])->name('edit-meanused')->where('id', '[0-9]+');
            Route::put('/{id}/update', [MeanusedController::class, 'update'])->name('update-meanused')->where('id', '[0-9]+');
        });
        Route::prefix('placeuse')->group(function () {
            Route::get('/create', [PlaceuseController::class, 'create'])->name('create-placeuse');
            Route::post('/create', [PlaceuseController::class, 'store'])->name('store-placeuse');
            Route::delete('/{id}', [PlaceuseController::class, 'destroy'])->name('destroy-placeuse')->where('id', '[0-9]+');
            Route::get('/{id}/update', [PlaceuseController::class, 'edit'])->name('edit-placeuse')->where('id', '[0-9]+');
            Route::put('/{id}/update', [PlaceuseController::class, 'update'])->name('update-placeuse')->where('id', '[0-9]+');
        });
        Route::prefix('user')->group(function () {
            Route::delete('/{id}', [UserController::class, 'destroy'])->name('destroy-user')->where('id', '[0-9]+');
            Route::get('/', [UserController::class, 'index'])->name('index-user');
        });
        Route::prefix('occurrence')->group(function () {
            Route::prefix('{occurrence_id}/victim')->where(['occurrence_id' => '[0-9]+'])->group(function () {
                Route::delete('/{id}', [VictimController::class, 'destroy'])->name('destroy-victim')->where('id', '[0-9]+');
                Route::get('/{id}/update', [VictimController::class, 'edit'])->name('edit-victim')->where('id', '[0-9]+');
                Route::put('/{id}/update', [VictimController::class, 'update'])->name('update-victim')->where('id', '[0-9]+');
            });

            Route::prefix('{occurrence_id}/resource')->where(['occurrence_id' => '[0-9]+'])->group(function () {
                Route::delete('/{id}', [ResourceController::class, 'destroy'])->name('destroy-resource')->where('id', '[0-9]+');
                Route::get('/{id}/update', [ResourceController::class, 'edit'])->name('edit-resource')->where('id', '[0-9]+');
                Route::put('/{id}/update', [ResourceController::class, 'update'])->name('update-resource')->where('id', '[0-9]+');
            });

            Route::delete('/{id}', [OccurrenceController::class, 'destroy'])->name('destroy-occurrence')->where('id', '[0-9]+');
            Route::get('/{id}/update', [OccurrenceController::class, 'edit'])->name('edit-occurrence')->where('id', '[0-9]+');
            Route::put('/{id}/update', [OccurrenceController::class, 'update'])->name('update-occurrence')->where('id', '[0-9]+');
        });
        Route::get('profile/password/{id}', [UserController::class, 'changePasswordID'])->name('passwordId')->where('id', '[0-9]+');
    });
    Route::prefix('nature')->group(function () {
        Route::get('/', [NatureController::class, 'index'])->name('index-nature');
        Route::get('/{id}', [NatureController::class, 'show'])->name('show-nature')->where('id', '[0-9]+');
    });

    Route::prefix('type')->group(function () {
        Route::get('/', [TypeController::class, 'index'])->name('index-type');
        Route::get('/{id}', [TypeController::class, 'show'])->name('show-type')->where('id', '[0-9]+');
    });

    Route::prefix('fireprotection')->group(function () {
        Route::get('/', [FireprotectionController::class, 'index'])->name('index-fireprotection');
        Route::get('/{id}', [FireprotectionController::class, 'show'])->name('show-fireprotection')->where('id', '[0-9]+');
    });

    Route::prefix('rescuer')->group(function () {
        Route::get('/', [RescuerController::class, 'index'])->name('index-rescuer');
    });

    Route::prefix('problem')->group(function () {
        Route::get('/', [ProblemController::class, 'index'])->name('index-problem');
        Route::get('/{id}', [ProblemController::class, 'show'])->name('show-problem')->where('id', '[0-9]+');
    });
    Route::prefix('placefreature')->group(function () {
        Route::get('/', [PlacefreatureController::class, 'index'])->name('index-placefreature');
    });
    Route::prefix('meanused')->group(function () {
        Route::get('/', [MeanusedController::class, 'index'])->name('index-meanused');
    });
    Route::prefix('placeuse')->group(function () {
        Route::get('/', [PlaceuseController::class, 'index'])->name('index-placeuse');
    });

    Route::prefix('user')->group(function () {
        Route::get('/{id}', [UserController::class, 'show'])->name('show-user')->where('id', '[0-9]+');
        Route::get('/{id}/update', [UserController::class, 'edit'])->name('edit-user')->where('id', '[0-9]+');
        Route::put('/{id}/update', [UserController::class, 'update'])->name('update-user')->where('id', '[0-9]+');
    });

    Route::prefix('occurrence')->group(function () {
        Route::get('/', [OccurrenceController::class, 'index'])->name('index-occurrence');
        Route::get('/{id}', [OccurrenceController::class, 'show'])->name('show-occurrence')->where('id', '[0-9]+');
        Route::get('/{id}/pdf', [OccurrenceController::class, 'toPdf'])->name('toPdf-occurrence')->where('id', '[0-9]+');


        Route::prefix('{occurrence_id}/victim')->where(['occurrence_id' => '[0-9]+'])->group(function () {
            Route::get('/', [VictimController::class, 'index'])->name('index-victim');
            Route::get('/{id}', [VictimController::class, 'show'])->name('show-victim')->where('id', '[0-9]+');
            Route::get('/create', [VictimController::class, 'create'])->name('create-victim');
            Route::post('/create', [VictimController::class, 'store'])->name('store-victim');
        });

        Route::prefix('{occurrence_id}/resource')->where(['occurrence_id' => '[0-9]+'])->group(function () {
            Route::get('/', [ResourceController::class, 'index'])->name('index-resource');
            Route::get('/{id}', [ResourceController::class, 'show'])->name('show-resource')->where('id', '[0-9]+');
            Route::get('/create', [ResourceController::class, 'create'])->name('create-resource');
            Route::post('/create', [ResourceController::class, 'store'])->name('store-resource');
        });

        Route::get('/create', [OccurrenceController::class, 'create'])->name('create-occurrence');
        Route::post('/create', [OccurrenceController::class, 'store'])->name('store-occurrence');
    });

    Route::get('profile', [UserController::class, 'profile'])->name('profile');
    Route::get('profile/password', [UserController::class, 'changePassword'])->name('password');
    Route::put('profile/password/{id}', [UserController::class, 'storePassword'])->name('password-store')->where('id', '[0-9]+');
});
