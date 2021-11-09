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




//

Route::domain('www.taco.test')->group(function () {


    Route::group([
      //  'namespace' => 'Feedback',
        'prefix' => 'feedback',
        'as' => 'feedback.',
//'middleware' => ['adminauth']
    ], function () {

     //   Auth::routes();
        Route::get('/', [\App\Http\Controllers\Auth\LoginController::class ,'showAdminLoginForm']);

        Route::post('/login-check', [\App\Http\Controllers\Auth\LoginController::class ,'adminLogin'])->name('login');
   //     Route::post('/register/admin', 'Auth\RegisterController@createAdmin');
   //     Route::view('/home', 'home')->middleware('auth');


//        Route::get('login', [\App\Http\Controllers\Feedback\AuthController::class, 'showLoginForm'])->name('login');
//        Route::post('custom-login', [\App\Http\Controllers\Feedback\AuthController::class, 'login'])->name('login.custom');
//
//        Route::get('registration', [\App\Http\Controllers\Feedback\RegisterController::class, 'register'])->name('register-user');
//        Route::post('custom-registration', [\App\Http\Controllers\Feedback\RegisterController::class, 'customRegistration'])->name('register.custom');
//
//        Route::post('complete-registration', [\App\Http\Controllers\Feedback\RegisterController::class, 'completeRegistration'])->name('complete.register');
//        Route::post('/2fa', function () {
//            return redirect(URL()->previous());
//        })->name('2fa')->middleware('2fa');

        Route::group([
            'middleware' => ['auth:admin']
        ], function () {

            Route::get('/dashboard',[\App\Http\Controllers\Feedback\AdminsController::class,'dashboard'])->name('dashboard');
            Route::post('logout', [\App\Http\Controllers\Feedback\AdminsController::class, 'logout'])->name('logout');

            Route::resource('tenants',\App\Http\Controllers\Feedback\TenantsController::class);
            Route::resource('admins',\App\Http\Controllers\Feedback\AdminsController::class);
            Route::resource('roles',\App\Http\Controllers\Feedback\RolesController::class);
        });
    });
});


