<?php

use App\Http\Controllers\AlmacenesController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DepartamentosController;
use App\Http\Controllers\MarcasController;

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

});
