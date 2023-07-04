<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KeepfileController; //add
use App\Http\Controllers\ClientCorporationController;//add
use App\Http\Controllers\ClientController;//add

use App\Http\Livewire\ClientCorporationSearchModal;
use App\Http\Livewire\ClientForm;

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

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware('auth')->group(function () {
    Route::resource('/keepfile','\App\Http\Controllers\KeepfileController');
    Route::resource('/clientcorporation','\App\Http\Controllers\ClientCorporationController');
    Route::resource('/client','\App\Http\Controllers\ClientController');
    Route::resource('/user', '\App\Http\Controllers\UserController');
    // Route::get('/clientcorporation/search', [ClientController::class, 'searchClientCorporations'])->name('clientcorporation.search');
    // Route::get('/clientcorporation/search', [ClientCorporationController::class, 'search'])->name('clientcorporation.search');
    // Route::get('/client/create', [ClientController::class, 'create'])->name('client.create');
    // Route::post('/client', [ClientController::class, 'store'])->name('client.store');
    // Route::get('/clientcorporation/search', 'ClientCorporationController@search');
    // Route::get('/corporations/search', [ClientCorporationController::class, 'search'])->name('corporations.search');
    Route::post('/clientcorporation/search', [ClientCorporationController::class, 'search'])->name('clientcorporation.search');

       

});

require __DIR__.'/auth.php';