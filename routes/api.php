<?php

use App\Http\Controllers\AsesoriaController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PagoController;
use App\Http\Controllers\MetricasController;
use App\Http\Controllers\Api\CalendlyWebhookController;
use App\Http\Controllers\Api\UserController;


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

Route::get('/pagos', [PagoController::class, 'index']);
Route::post('/pagos', [PagoController::class, 'createPago']);


Route::post("/asesorias", [AsesoriaController::class, 'create']);
Route::get("/asesorias/{id}", [AsesoriaController::class, 'show']);
Route::post("/asesorias/update", [AsesoriaController::class, 'actualizar'])->name('asesorias.actualizar');


Route::get("/metricas/afiliaciones", [MetricasController::class, 'afiliaciones'])->name('metricas.afiliaciones');
Route::get("/metricas/citas", [MetricasController::class, 'citas'])->name('metricas.citas');
Route::get("/metricas/usuario_residencia", [MetricasController::class, 'usuario_residencia'])->name('metricas.usuario_residencia');
Route::get("/metricas/usuario_identidades", [MetricasController::class, 'usuario_identidades'])->name('metricas.usuario_identidades');
Route::get("/metricas/usuario_pronombres", [MetricasController::class, 'usuario_pronombres'])->name('metricas.usuario_pronombres');
Route::get("/metricas/usuario_afro_indigena", [MetricasController::class, 'usuario_afro_indigena'])->name('metricas.usuario_afro_indigena');
Route::get("/metricas/usuarios_afiliados", [MetricasController::class, 'usuarios_afiliados'])->name('metricas.usuarios_afiliados');
// Calendly Webhook
Route::post('/webhook/calendly/subscribe', [CalendlyWebhookController::class, 'subscribeToWebhook']);
Route::get('/webhook/calendly/data', [CalendlyWebhookController::class, 'getDataCalendly']);
Route::get('/webhook/calendly/list', [CalendlyWebhookController::class, 'getListWebhook']);
Route::post('/webhook/calendly', [CalendlyWebhookController::class, 'handleWebhook'])->name('calendly.webhook.handle');
Route::get('/webhook/calendly/test', [CalendlyWebhookController::class, 'testInsert']);

// login and register
Route::post('/register', [UserController::class, 'register']);
Route::post('/login', [UserController::class, 'login']);
