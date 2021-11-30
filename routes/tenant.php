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


        Route::get('/', [\App\Http\Controllers\HomeController::class,'index'])->name('home');

        Route::group(['prefix'=>'hr', 'as' => 'hr.',],function (){
            Route::get('roles/permissions',[\App\Http\Controllers\Hr\RolesController::class,'permissions'])->name('roles.permissions');
            Route::post('roles/permissions',[\App\Http\Controllers\Hr\RolesController::class,'permissionsCreate']);
            Route::delete('permission/delete/{id}',[\App\Http\Controllers\Hr\RolesController::class,'permissionsDelete'])->name('permission.delete');

            Route::resource('users',\App\Http\Controllers\Hr\UsersController::class);
            Route::resource('roles',\App\Http\Controllers\Hr\RolesController::class);
            Route::resource('employees',\App\Http\Controllers\Hr\EmployeesController::class);
        });




        Route::group(['prefix'=>'crm', 'as' => 'crm.',],function (){
            Route::resource('clients',\App\Http\Controllers\Crm\ClientsController::class);
            Route::resource('companies',\App\Http\Controllers\Crm\CompaniesController::class);
            Route::resource('actions',\App\Http\Controllers\Crm\ActionsController::class);
        });

        Route::group(['prefix'=>'formulas', 'as' => 'formulas.',],function (){
            Route::get('categories/',[\App\Http\Controllers\Formulas\CategoriesController::class,'index'])->name('categories.index');
            Route::get('categories/{id}',[\App\Http\Controllers\Formulas\CategoriesController::class,'show'])->name('categories.show');
            Route::get('elements',[\App\Http\Controllers\Formulas\ElementsController::class,'index'])->name('elements.index');
            Route::get('elements/{id}',[\App\Http\Controllers\Formulas\ElementsController::class,'show'])->name('elements.show');
            Route::get('compounds',\App\Http\Controllers\Formulas\CompoundsController::class)->name('compounds');
            Route::resource('formulas',\App\Http\Controllers\Formulas\FormulasController::class);
        });

        Route::group(['prefix'=>'purchases', 'as' => 'purchases.',],function (){
            Route::resource('bills',\App\Http\Controllers\Purchases\BillsController::class);
            Route::resource('vendors',\App\Http\Controllers\Purchases\VendorController::class);
        });

        Route::group(['prefix'=>'inventory', 'as' => 'inventory.',],function (){
            Route::get('/',[\App\Http\Controllers\Inventory\InventoryController::class,'index'])->name('index');
            Route::get('/pending',[\App\Http\Controllers\Inventory\InventoryController::class,'pending'])->name('pending');
            Route::get('/products',[\App\Http\Controllers\Inventory\InventoryController::class,'products'])->name('products');
            Route::post('/add',[\App\Http\Controllers\Inventory\InventoryController::class,'add'])->name('add');
            Route::get('/{id}',[\App\Http\Controllers\Inventory\InventoryController::class,'show'])->name('show');
            Route::get('/{id}/insert',[\App\Http\Controllers\Inventory\InventoryController::class,'insert'])->name('insert');
        });

        Route::group(['prefix'=>'production', 'as' => 'production.',],function (){
            Route::get('/',[\App\Http\Controllers\Production\ProductionOrderController::class,'index'])->name('index');
            Route::get('/create',[\App\Http\Controllers\Production\ProductionOrderController::class,'create'])->name('create');
         //   Route::get('/products',[\App\Http\Controllers\Production\ProductsController::class,'index'])->name('products.index');
            Route::resource('products',\App\Http\Controllers\Production\ProductsController::class);

            Route::get('/{id}',[\App\Http\Controllers\Production\ProductionOrderController::class,'show'])->name('show');
            Route::get('/{id}/print',[\App\Http\Controllers\Production\ProductionOrderController::class,'print'])->name('print');
            Route::get('/{id}/pdf',[\App\Http\Controllers\Production\ProductionOrderController::class,'pdf'])->name('pdf');
            Route::get('/{id}/done',[\App\Http\Controllers\Production\ProductionOrderController::class,'done'])->name('done');
        });
        Route::group(['prefix'=>'sales', 'as' => 'sales.',],function (){

        });
        Route::group(['prefix'=>'setting', 'as' => 'setting.',],function (){
            Route::get('/',[\App\Http\Controllers\HomeController::class,'setting'])->name('index');
        });


        Route::get('notifications',[\App\Http\Controllers\HomeController::class ,'notifications'])->name('notifications');



        Route::get('404',function (){
            abort(404);
        })->name('404');


    });

});
