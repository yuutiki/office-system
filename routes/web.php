<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KeepfileController; //add
use App\Http\Controllers\ClientCorporateController;//add
use App\Http\Controllers\ClientController;//add

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
    Route::resource('/clientcorporate','\App\Http\Controllers\ClientCorporateController');
    Route::resource('/client','\App\Http\Controllers\ClientController');
    Route::resource('/user', '\App\Http\Controllers\UserController')->only(['index', 'store', 'update', 'destroy']);
});

require __DIR__.'/auth.php';
