<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('productos', [App\Http\Controllers\ProductoController::class, 'index'])->name('productos.index');
Route::post('productos', [App\Http\Controllers\ProductoController::class, 'create'])->name('productos.create');
Route::get('productos/{producto}', [App\Http\Controllers\ProductoController::class, 'index'])->name('productos.detalle');
Route::put('productos/{producto}', [App\Http\Controllers\ProductoController::class, 'update'])->name('productos.update');
Route::delete('productos/{producto}', [App\Http\Controllers\ProductoController::class, 'delete'])->name('productos.delete');
