<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KeepfileController; //add
use App\Http\Controllers\ClientCorporationController;//add
use App\Http\Controllers\ClientController;//add
// use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Dashboard\DashboardController;//add
use App\Http\Controllers\CommentController;//add
use App\Http\Controllers\ReportController;//add
use App\Http\Controllers\ProductController;//add
use App\Http\Controllers\UserController;//add

use App\Http\Livewire\ClientCorporationSearchModal;
use App\Http\Livewire\ClientForm;
use App\Models\Product;

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

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

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
    Route::resource('/report', '\App\Http\Controllers\ReportController');
    Route::resource('/product', '\App\Http\Controllers\ProductController');
    Route::resource('/support', '\App\Http\Controllers\SupportController');
    Route::resource('/project', '\App\Http\Controllers\ProjectController');
    Route::resource('/link', '\App\Http\Controllers\LinkController');

    //マスタ系
    Route::resource('/masters', '\App\Http\Controllers\MasterController');
    // Route::resource('/comment', '\App\Http\Controllers\CommentController');
    Route::post('/clientcorporation/search', [ClientCorporationController::class, 'search'])->name('clientcorporation.search');
    Route::post('/clientcorporation/upload', [ClientCorporationController::class, 'upload'])->name('clientcorporation.upload');
    Route::post('/user/upload', [UserController::class, 'upload'])->name('user.upload');
    Route::post('/client/search', [ClientController::class, 'search'])->name('client.search');
    Route::get('/report/{report_id}/comment', [CommentController::class, 'show'])->name('comment.show');
    Route::post('/report/{report_id}/comment', [CommentController::class, 'store'])->name('comment.store');
    Route::get('/report/{report_id}/client', [ReportController::class, 'showFromClient'])->name('report.showFromClient');
    Route::post('/product/upload', [ProductController::class, 'upload'])->name('product.upload');


    // Route::get('/product-selection', 'ProductController@index');
    Route::get('/get-split-types/{productTypeId}', [ProductController::class, 'getSplitTypes'])->name('product.getSplitTypes');

});

// Route::resource('/dashboard', '\App\Http\Controllers\DashboardController')->middleware(['auth', 'verified'])->name('dashboard');
Route::get('/dashboard',  [DashboardController::class, 'index'])->name('dashboard')->middleware(['auth', 'verified']);

require __DIR__.'/auth.php';