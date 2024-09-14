<?php

use App\Http\Controllers\AsesoriaController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\RolController;
use App\Http\Controllers\PermisoController;
use App\Http\Controllers\PagoController;
use App\Http\Controllers\SuscripcionController;
use App\Http\Controllers\AsignarController;
use App\Http\Controllers\TextoController;
use App\Http\Controllers\MapaController;
use App\Models\WebsiteText;
use App\Models\PointOfInterest;


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
    //pasar los textos de los programas
    $programas = WebsiteText::where('section', 'programas')->get();
    $points = PointOfInterest::all();
    return view('welcome', compact('programas', 'points'));
})->name('landing_page');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {



    Route::middleware(['role:Administrador'])->group(function () {

        Route::get('/profile', [ProfileController::class, 'index'])->name('profile');

        Route::resource('/productos', ProductoController::class)->names('productos');

        Route::resource('/roles', RolController::class)->names('roles');
        Route::resource('/permisos', PermisoController::class)->names('permisos');

        Route::get('/dashboard', function () {
            return view('dashboard');
        })->name('dashboard');


        Route::get('/suscripciones', [SuscripcionController::class, 'index'])->name("suscripciones.index");
        Route::post('/suscripciones/actualizar', [SuscripcionController::class, 'actualizarSuscripcion'])->name("suscripciones.actualizarSuscripcion");

        Route::get('/pagos', [PagoController::class, 'index'])->name('pagos.index');
        Route::get('/pagos/comprobante/{id}', [PagoController::class, 'displayPhoto'])->name("pagos.displayPhoto");
        Route::post('/pagos/validar', [PagoController::class, 'validarPago'])->name('pagos.validarPago');

        Route::get('/suscripciones', [SuscripcionController::class, 'index'])->name("suscripciones.index");
        Route::post('/suscripciones/actualizar', [SuscripcionController::class, 'actualizarSuscripcion'])->name("suscripciones.actualizarSuscripcion");

        Route::get('/asesorias', [AsesoriaController::class, 'index'])->name('asesorias.index');
        Route::post("/asesorias/update", [AsesoriaController::class, 'actualizar'])->name('asesorias.actualizar');


        Route::resource('/usuarios', AsignarController::class)->names('usuarios');

        Route::get('/roles/{role}/permisos', [RolController::class, 'permisos'])->name('roles.permisos');
        Route::put('/roles/{role}/asignarPermisos', [RolController::class, 'asignarPermisos'])->name('roles.asignarPermisos');

        Route::resource('/texto', TextoController::class)->names('texto');
        Route::put('/textos', [TextoController::class, 'update'])->name('texts.update');
        Route::resource('/puntos', MapaController::class)->names('puntos');
    });
});
