<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
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

// Calendly Webhook
Route::post('/webhook/calendly/subscribe', [CalendlyWebhookController::class, 'subscribeToWebhook']);
Route::get('/webhook/calendly/data', [CalendlyWebhookController::class, 'getDataCalendly']);
Route::get('/webhook/calendly/list', [CalendlyWebhookController::class, 'getListWebhook']);
Route::post('/webhook/calendly', [CalendlyWebhookController::class, 'handleWebhook'])->name('calendly.webhook.handle');
Route::get('/webhook/calendly/test', [CalendlyWebhookController::class, 'testInsert']);

// login and register
Route::post('/register', [UserController::class, 'register']);
Route::post('/login', [UserController::class, 'login']);
