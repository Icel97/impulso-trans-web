<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\RolController;
use App\Http\Controllers\PermisoController;
use App\Http\Controllers\PagoController; 
use App\Http\Controllers\SuscripcionController;
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
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
    Route::get('/profile',[ProfileController::class, 'index'])->name('profile');
    Route::resource('/productos', ProductoController::class)->names('productos');
    Route::resource('/roles', RolController::class)->names('roles');
    Route::resource('/permisos', PermisoController::class)->names('permisos');


    #pagos
    Route::get('/pagos', [PagoController::class, 'index'])->name('pagos.index'); 
    Route::get('/pagos/comprobante/{id}', [PagoController::class, 'displayPhoto'])->name("pagos.displayPhoto");
    Route::post('/pagos/validar', [PagoController::class, 'validarPago'])->name('pagos.validarPago'); 
    #suscripciones
    Route::get('/suscripciones', [SuscripcionController::class, 'index'])->name("suscripciones.index");
    Route::post('/suscripciones/actualizar', [SuscripcionController::class, 'actualizarSuscripcion'])->name("suscripciones.actualizarSuscripcion"); 
    


});
