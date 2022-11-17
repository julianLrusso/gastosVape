<?php

use App\Http\Controllers\ProductosController;
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
    return view('home');
});

// Productos
Route::get('productos', [ProductosController::class, 'all'])->name('productos.listado');
Route::get('producto/{id}', [ProductosController::class, 'show'])->name('productos.show');
Route::get('agregarProducto', [ProductosController::class, 'createForm'])->name('productos.agregar');
Route::post('productos/create', [ProductosController::class, 'create'])->name('productos.create');
Route::put('producto/{id}/update', [ProductosController::class, 'update'])->name('productos.update');
Route::delete('producto/{id}/eliminar', [ProductosController::class, 'delete'])->name('productos.delete');
Route::post('producto/{id}/restore', [ProductosController::class, 'restore'])->name('productos.restore');

Route::get('ingresos', function () {
    return view('facturacion.ingresos');
});

Route::get('ventas', function () {
    return view('facturacion.ventas');
});
