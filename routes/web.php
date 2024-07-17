<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\RolController;
use App\Http\Controllers\PermisoController;
use App\Http\Controllers\AsignarController;

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
    Route::resource('/usuarios', AsignarController::class)->names('usuarios');

    // Agregar la ruta específica para roles.permisos
    Route::get('/roles/{role}/permisos', [RolController::class, 'permisos'])->name('roles.permisos');
    // Agregar la ruta específica para roles.permisos.asignarPermisos
    Route::put('/roles/{role}/asignarPermisos', [RolController::class, 'asignarPermisos'])->name('roles.asignarPermisos');
});
