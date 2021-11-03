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






Route::middleware('tenant')->group(function() {

    Auth::routes([
        'register' => false, // Registration Routes...
        'reset' => false, // Password Reset Routes...
        'verify' => false, // Email Verification Routes...
    ]);


    Route::group(['middleware'=>['auth:web','active']],function (){


        Route::get('/', function () {
//            dd(Request::getHost());
//            dd(    Spatie\Multitenancy\Models\Tenant::where('domain'));
            return view('home');
        })->name('home');


        Route::get('roles/permissions',[\App\Http\Controllers\RolesController::class,'permissions'])->name('roles.permissions');
        Route::post('roles/permissions',[\App\Http\Controllers\RolesController::class,'permissionsCreate']);
        Route::delete('permission/delete/{id}',[\App\Http\Controllers\RolesController::class,'permissionsDelete'])->name('permission.delete');

      //  Route::get('categories',[\App\Http\Controllers\CategoriesController::class,'index'])->name('categories');
        Route::get('elements',[\App\Http\Controllers\ElementsController::class,'index'])->name('elements.index');
        Route::get('categories',[\App\Http\Controllers\CategoriesController::class,'index'])->name('categories.index');
        Route::get('elements/{id}',[\App\Http\Controllers\ElementsController::class,'show'])->name('elements.show');
        Route::get('categories/{id}',[\App\Http\Controllers\CategoriesController::class,'show'])->name('categories.show');

        Route::resource('users',\App\Http\Controllers\UsersController::class);
        Route::resource('roles',\App\Http\Controllers\RolesController::class);

        Route::resource('formulas',\App\Http\Controllers\FormulasController::class);




    });
}); // end of tenant middleware
