<?php

use App\Http\Controllers\Admin\Api\ClienteApiController;
use App\Http\Controllers\Admin\Api\MaterialApiController;
use App\Http\Controllers\Admin\Api\VentaApiController;
use App\Http\Controllers\Admin\Api\VolquetaApiController;
use App\Http\Controllers\Admin\ClienteController;
use App\Http\Controllers\Admin\ClienteMaterialController;
use App\Http\Controllers\Admin\MaterialController;
use App\Http\Controllers\Admin\PrecioMaterialController;
use App\Http\Controllers\Admin\VentaController;
use App\Http\Controllers\Admin\VolquetaController;
use Illuminate\Support\Facades\Route;

Route::get('/', function(){
    return view('admin.dashboard');
})->name('dashboard');

Route::resource('volquetas', VolquetaController::class);

Route::resource('clientes', ClienteController::class);

Route::resource('ventas', VentaController::class);
Route::get('ventas/cliente/{cliente}', [VentaController::class, 'showCliente'])
    ->name('ventas.cliente');
Route::get('ventas/{venta}/print', [VentaController::class, 'print'])
    ->name('ventas.print');
Route::get('ventas/cliente/{cliente}/exportar', [VentaController::class, 'exportarCliente'])
    ->name('ventas.cliente.exportar');


Route::resource('material', MaterialController::class);
Route::resource('preciomaterial', ClienteMaterialController::class);

// APIs
Route::get('/api/volquetas/buscar/{placa}', [VolquetaApiController::class, 'buscarPorPlaca'])
    ->name('admin.api.volquetas.buscar');

Route::get('/api/clientes', [ClienteApiController::class, 'listar'])
    ->name('admin.api.clientes.listar');

Route::get('api/volquetas', [VolquetaApiController::class, 'index']);

Route::get('/api/materiales', [MaterialApiController::class, 'listar'])
    ->name('admin.api.materiales.listar');

Route::get('/api/ventas/siguiente-ticket', [VentaApiController::class, 'siguienteTicket'])
    ->name('admin.api.ventas.siguiente-ticket');