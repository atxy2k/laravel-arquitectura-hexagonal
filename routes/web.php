<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\DashboardController;
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

});
