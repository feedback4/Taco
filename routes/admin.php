<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;


Route::domain('www.taco.test')->group(function () {
    Route::group([
        'as' => 'feedback.',
//'middleware' => ['adminauth']
    ], function () {


        Route::get('login', [\App\Http\Controllers\Feedback\AuthController::class, 'index'])->name('login');
        Route::post('custom-login', [\App\Http\Controllers\Feedback\AuthController::class, 'customLogin'])->name('login.custom');
        Route::get('registration', [\App\Http\Controllers\Feedback\AuthController::class, 'register'])->name('register-user');
        Route::post('custom-registration', [\App\Http\Controllers\Feedback\AuthController::class, 'customRegistration'])->name('register.custom');



        Route::group([
            'middleware' => ['adminauth']
        ], function () {

        Route::get('/',[\App\Http\Controllers\Feedback\AdminsController::class,'dashboard'])->name('dashboard');
            Route::get('signout', [\App\Http\Controllers\Feedback\AuthController::class, 'signOut'])->name('signout');

        Route::resource('tenants',\App\Http\Controllers\Feedback\TenantsController::class);
        Route::resource('admins',\App\Http\Controllers\Feedback\AdminsController::class);
        Route::resource('roles',\App\Http\Controllers\Feedback\RolesController::class);
        });
    });
});

