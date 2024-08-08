<?php

use App\Http\Controllers\AsesoriaController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PagoController;
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
//get one 
Route::get("/asesorias/{id}", [AsesoriaController::class, 'show']);
Route::post("/asesorias/update", [AsesoriaController::class, 'actualizar'])->name('asesorias.actualizar');
