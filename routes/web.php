<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ClientesController;
use App\Http\Controllers\FacturacionController;
use App\Http\Controllers\ProductosController;
use App\Http\Controllers\UsuariosController;
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

Route::get('/login', [AuthController::class, 'formLogin'])->name('formLogin');
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware(['auth', \App\Http\Middleware\isAdmin2::class])->group(function () {
    // Registrar
    Route::get('/register', [AuthController::class, 'formRegister'])->name('formRegister');
    Route::post('/register', [AuthController::class, 'register'])->name('register');

    // Usuarios
    Route::get('/usuarios', [UsuariosController::class, 'getAll'])->name('usuarios.listado');
    Route::get('/cambiarContraseña/{id}', [UsuariosController::class, 'changePasswordForm'])->name('usuarios.changeForm');
    Route::post('/cambiarContraseña', [AuthController::class, 'changePassword'])->name('usuarios.changePassword');
    Route::delete('/eliminarUsuario', [UsuariosController::class, 'eraseUsuario'])->name('usuarios.eraseUsuario');

    // Facturas
    Route::get('editarFactura/{id}', [FacturacionController::class, 'showEditForm'])->name('facturacion.editFacturaForm');
    Route::put('editarFactura/{id}', [FacturacionController::class, 'editarFactura'])->name('facturacion.editFactura');
    Route::delete('eliminarFactura/{id}', [FacturacionController::class, 'eliminarFacturaVenta'])->name('facturacion.eliminarFacturaVenta');
    Route::delete('eliminarFacturaCompra/{id}', [FacturacionController::class, 'eliminarFacturaCompra'])->name('facturacion.eliminarFacturaCompra');

});

Route::middleware(['auth'])->group(function () {
// Home
    Route::get('/',[FacturacionController::class, 'home'])->name('home');
    Route::post('/',[FacturacionController::class, 'homeFiltrado'])->name('homeFiltrado');

// Productos
    Route::get('productos', [ProductosController::class, 'all'])->name('productos.listado');
    Route::post('productos', [ProductosController::class, 'listadoFiltrado'])->name('productos.listadoFiltrado');
    Route::get('producto/{id}', [ProductosController::class, 'show'])->name('productos.show');
    Route::get('agregarProducto', [ProductosController::class, 'createForm'])->name('productos.agregar');
    Route::post('productos/create', [ProductosController::class, 'create'])->name('productos.create');
    Route::put('producto/{id}/update', [ProductosController::class, 'update'])->name('productos.update');
    Route::delete('producto/{id}/eliminar', [ProductosController::class, 'delete'])->name('productos.delete');
    Route::post('producto/{id}/restore', [ProductosController::class, 'restore'])->name('productos.restore');

// Clientes
    Route::get('clientes', [ClientesController::class, 'all'])->name('clientes.listado');
    Route::post('clientes', [ClientesController::class, 'listadoFiltrado'])->name('clientes.listadoFiltrado');
    Route::get('cliente/{id}', [ClientesController::class, 'show'])->name('clientes.show');
    Route::post('clientes/create', [ClientesController::class, 'create'])->name('clientes.create');
    Route::get('agregarCliente', [ClientesController::class, 'createForm'])->name('clientes.agregar');
    Route::put('cliente/{id}/update', [ClientesController::class, 'update'])->name('clientes.update');
    Route::delete('cliente/{id}/eliminar', [ClientesController::class, 'delete'])->name('clientes.delete');
    Route::post('cliente/{id}/restore', [ClientesController::class, 'restore'])->name('clientes.restore');

// Facturacion
    Route::get('facturas', [FacturacionController::class, 'listadoFacturas'])->name('facturacion.listado');
    Route::post('facturas', [FacturacionController::class, 'listadoFacturasFiltrado'])->name('facturacion.listadoFiltrado');

    Route::get('ingresos', [FacturacionController::class, 'ingresos'])->name('facturacion.ingresos');
    Route::post('ingresos', [FacturacionController::class, 'createIngreso'])->name('facturacion.crearIngreso');
    Route::get('factura/{id}', [FacturacionController::class, 'showIngreso'])->name('facturacion.showIngreso');

    Route::get('ventas', [FacturacionController::class, 'ventas'])->name('facturacion.showVentas');
    Route::post('ventas',[FacturacionController::class, 'createVenta'])->name('facturacion.createVenta');

// Autenticación
    Route::get('iniciar-sesion', [AuthController::class, 'formLogin'])->name('auth.formLogin');
    Route::get('registrarse', [AuthController::class, 'formRegister'])->name('auth.formRegister');
    Route::post('iniciar-sesion', [AuthController::class, 'login'])->name('auth.login');
    Route::post('registrarse', [AuthController::class, 'register'])->name('auth.register');
    Route::post('cerrar-sesion', [AuthController::class, 'logout'])->name('auth.logout');

});
