<?php

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

// redirige vers les avions ou vols
Route::get('/', [AvionController::class, 'index']);

// Création des routes avec resources  
Route::resources([
    'avions' => AvionController::class,
    'vols'   => VolController::class,
]);
