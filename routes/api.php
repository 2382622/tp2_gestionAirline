<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\VolController as VolApiController;
use App\Http\Controllers\API\AvionController as AvionApiController;
use App\Http\Controllers\API\UserController as UserApiController;
use App\Http\Controllers\API\TicketController as TicketApiController;
use App\Http\Controllers\API\AuthController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

// Auth public
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// Lecture publique des vols
Route::get('/vols', [VolApiController::class, 'index']);
Route::get('/vols-home', [VolApiController::class, 'homeRandom']);
// Lecture publique des avions (pour formulaires)
Route::get('/avions', [AvionApiController::class, 'index']);

// Routes protégées Sanctum
Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('users', UserApiController::class);
    Route::apiResource('vols', VolApiController::class)->except(['index']);
    Route::apiResource('avions', AvionApiController::class)->except(['index']);
    Route::apiResource('tickets', TicketApiController::class);
});
