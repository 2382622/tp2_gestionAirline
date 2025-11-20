<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\VolController as VolApiController;
use App\Http\Controllers\API\AvionController as AvionApiController;
use App\Http\Controllers\API\UserController as UserApiController;
use App\Http\Controllers\API\TicketController as TicketApiController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
use App\Http\Controllers\API\AuthController;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);


Route::apiResource('vols', VolApiController::class);
Route::apiResource('avions', AvionApiController::class);
Route::apiResource('users', UserApiController::class);
Route::apiResource('tickets', TicketApiController::class);