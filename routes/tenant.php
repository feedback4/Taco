<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Stancl\Tenancy\Middleware\InitializeTenancyByDomain;
use Stancl\Tenancy\Middleware\PreventAccessFromCentralDomains;

/*
|--------------------------------------------------------------------------
| Tenant Routes
|--------------------------------------------------------------------------
|
| Here you can register the tenant routes for your application.
| These routes are loaded by the TenantRouteServiceProvider.
|
| Feel free to customize them however you want. Good luck!
|
*/

Route::middleware([
    'web',
    InitializeTenancyByDomain::class,
    PreventAccessFromCentralDomains::class,
   \Stancl\Tenancy\Middleware\ScopeSessions::class,
])->group(function () {
//    Route::get('/', function () {
//       // dd(\App\Models\User::all());
//        return 'This is your multi-tenant application. The id of the current tenant is ' . tenant('id');
//    });

    Auth::routes([
        'register' => false, // Registration Routes...
        'reset' => false, // Password Reset Routes...
        'verify' => false, // Email Verification Routes...
    ]);



    Route::group(['middleware'=>['auth','active']],function (){


        Route::get('/', function () {

            return view('home');
        })->name('home');

        Route::get('roles/permissions',[\App\Http\Controllers\RolesController::class,'permissions'])->name('roles.permissions');
        Route::post('roles/permissions',[\App\Http\Controllers\RolesController::class,'permissionsCreate']);
        Route::delete('permission/delete/{id}',[\App\Http\Controllers\RolesController::class,'permissionsDelete'])->name('permission.delete');

        //  Route::get('categories',[\App\Http\Controllers\CategoriesController::class,'index'])->name('categories');

        Route::get('inventory',[\App\Http\Controllers\InventoryController::class,'index'])->name('inventory');
        Route::get('items/insert',[\App\Http\Controllers\InventoryController::class,'insert'])->name('items.insert');
        Route::post('items/store',[\App\Http\Controllers\InventoryController::class,'store'])->name('items.store');
         Route::get('accounting',[\App\Http\Controllers\InventoryController::class,'accounting'])->name('accounting');
        Route::get('elements',[\App\Http\Controllers\ElementsController::class,'index'])->name('elements.index');
        Route::get('categories',[\App\Http\Controllers\CategoriesController::class,'index'])->name('categories.index');
        Route::get('elements/{id}',[\App\Http\Controllers\ElementsController::class,'show'])->name('elements.show');
        Route::get('categories/{id}',[\App\Http\Controllers\CategoriesController::class,'show'])->name('categories.show');

        Route::resource('users',\App\Http\Controllers\UsersController::class);
        Route::resource('roles',\App\Http\Controllers\RolesController::class);

        Route::resource('formulas',\App\Http\Controllers\FormulasController::class);

        Route::get('dropbox',function (){
            abort(404);
        })->name('dropbox');
        Route::get('setting',function (){
            abort(404);
        })->name('setting');

        Route::get('404',function (){
            abort(404);
        })->name('404');


    });

});