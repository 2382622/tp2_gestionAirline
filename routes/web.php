<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AvionController;
use App\Http\Controllers\VolController;
use App\Http\Controllers\AccueilController;

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
Route::get('/', [AccueilController::class, 'index'])->name('accueil');
Route::post('/autocomplete/avions', [AvionController::class, 'autocomplete'])->name('avions.autocomplete');
Route::post('/autocomplete/vols',   [VolController::class, 'autocomplete'])->name('vols.autocomplete');
Route::get('lang/{locale}', [App\Http\Controllers\LocalizationController::class, 'index']);

// Création des routes avec resources  
Route::resources([
    'avions' => AvionController::class,
    'vols' => VolController::class,
]);


