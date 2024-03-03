<?php

use App\Http\Controllers\AlmacenesController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DepartamentosController;
use App\Http\Controllers\ExistenciasController;
use App\Http\Controllers\KardexController;
use App\Http\Controllers\MarcasController;
use App\Http\Controllers\ProductosController;
use App\Http\Controllers\RolesController;
use App\Http\Controllers\UsersController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return redirect()->route('dashboard.index');
});

Route::prefix('auth')->group(function(){

    Route::get('/', [LoginController::class, 'index'])->name('auth.login')->middleware(['guest']);
    Route::post('login', [LoginController::class,'login'])->name('auth.login_attempt');
    Route::get('logout', [LoginController::class, 'logout'])->name('auth.logout');

});

Route::prefix('admin')->middleware(['auth'])->group(function(){

    Route::get('/', [DashboardController::class,'index'])->name('dashboard.index');

    Route::prefix('marcas')->group(function(){
        Route::get('/', [MarcasController::class,'index'])->name('marcas.index');
        Route::get('add', [MarcasController::class,'add'])->name('marcas.add');
        Route::post('store', [MarcasController::class,'store'])->name('marcas.store');
        Route::get('change/{id}', [MarcasController::class, 'change'])->name('marcas.change');
        Route::post('change/{id}', [MarcasController::class, 'store_change'])->name('marcas.store_change');
        Route::get('delete/{id}', [MarcasController::class, 'delete'])->name('marcas.delete');
    });

    Route::prefix('departamentos')->group(function(){
        Route::get('/',[DepartamentosController::class,'index'])->name('departamentos.index');
        Route::get('add',[DepartamentosController::class,'add'])->name('departamentos.add');
        Route::post('store',[DepartamentosController::class,'store'])->name('departamentos.store');
        Route::get('change/{id}', [DepartamentosController::class, 'change'])->name('departamentos.change');
        Route::post('store-change/{id}', [DepartamentosController::class,'store_change'])->name('departamentos.store-change');
        Route::get('delete/{id}', [DepartamentosController::class, 'delete'])->name('departamentos.delete');
    });

    Route::prefix('almacenes')->group(function(){
        Route::get('/',[AlmacenesController::class,'index'])->name('almacenes.index');
        Route::get('add',[AlmacenesController::class,'add'])->name('almacenes.add');
        Route::post('store',[AlmacenesController::class,'store'])->name('almacenes.store');
        Route::get('change/{id}', [AlmacenesController::class, 'change'])->name('almacenes.change');
        Route::post('store-change/{id}', [AlmacenesController::class,'store_change'])->name('almacenes.store-change');
        Route::get('delete/{id}', [AlmacenesController::class, 'delete'])->name('almacenes.delete');
    });

    Route::prefix('roles')->group(function(){
        Route::get('/', [RolesController::class,'index'])->name('roles.index');
        Route::get('add', [RolesController::class,'add'])->name('roles.add');
        Route::post('store',[RolesController::class,'store'])->name('roles.store');
        Route::get('change/{id}', [RolesController::class, 'change'])->name('roles.change');
        Route::get('show/{id}', [RolesController::class, 'show'])->name('roles.show');
        Route::post('store-change/{id}', [RolesController::class,'store_change'])->name('roles.store-change');
        Route::get('delete/{id}', [RolesController::class, 'delete'])->name('roles.delete');
    });

    Route::prefix('users')->group(function(){
        Route::get('/', [UsersController::class,'index'])->name('users.index');
        Route::get('add', [UsersController::class,'add'])->name('users.add');
        Route::post('store',[UsersController::class,'store'])->name('users.store');
        Route::get('change/{id}', [UsersController::class, 'change'])->name('users.change');
        Route::post('store-change/{id}', [UsersController::class,'store_change'])->name('users.store-change');
        Route::get('delete/{id}', [UsersController::class, 'delete'])->name('users.delete');
    });

    Route::prefix('productos')->group(function(){
        Route::get('/', [ProductosController::class,'index'])->name('productos.index');
        Route::get('add', [ProductosController::class,'add'])->name('productos.add');
        Route::post('store',[ProductosController::class,'store'])->name('productos.store');
        Route::get('change/{id}', [ProductosController::class, 'change'])->name('productos.change');
        Route::post('store-change/{id}', [ProductosController::class,'store_change'])->name('productos.store-change');
        Route::get('delete/{id}', [ProductosController::class, 'delete'])->name('productos.delete');
    });

    Route::prefix('existencias')->group(function(){
        Route::get('/', [ExistenciasController::class,'index'])->name('existencias.index');
        Route::match(['get','post'],'add', [ExistenciasController::class,'add'])->name('existencias.add');
    });

    Route::prefix('kardex')->group(function(){
        Route::get('/', [KardexController::class, 'index'])->name('kardex.index');
    });

});
