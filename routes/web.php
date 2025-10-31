<?php

use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AvionController;
use App\Http\Controllers\VolController;
use App\Http\Controllers\AccueilController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\AdminTicketController;
    use Illuminate\Support\Facades\Mail;
    use App\Mail\MyTestMail; // If you created a Mailable class

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
Route::post('/autocomplete/vols', [VolController::class, 'autocomplete'])->name('vols.autocomplete');
Route::get('lang/{locale}', [App\Http\Controllers\LocalizationController::class, 'index']);

// Création des routes avec resources  
Route::resources([
    'avions' => AvionController::class,
    'vols' => VolController::class,
]);

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('tickets', AdminTicketController::class);
});
Route::middleware('auth')->group(function () {
    Route::resource('tickets', TicketController::class);
});


Route::get('/apropos', function () {
    return view('apropos');
})->name('apropos');


Auth::routes();
Auth::routes(['verify'=>true]);

Route::get('/email/verify',function(){
    return view('auth.verify');
})->middleware('auth')->name('verification.notice');

Route::get('/email.verify/{id}/{hash}',function(EmailVerificationRequest $request){
    $request->fulfill();

    return redirect('/home');
})->middleware(['auth','signed'])->name('verification.verify');

Route::post('/email/verification-notification',function(Request $request){
    $request->user()->sendEmailVerificationNotification();

    return back()->with('message','Verification link sent!');
})->middleware(['auth','throttle:6.1'])->name('verification.send');

Route::get('/send-test-email', function () {
    Mail::to('sirine___@outlook.com')->send(new MyTestMail()); 
    return "Email sent!";
});



