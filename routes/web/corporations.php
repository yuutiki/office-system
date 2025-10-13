<?php

use App\Http\Controllers\CorporationController;
use Illuminate\Support\Facades\Route;

Route::prefix('corporations')->name('corporations.')->group(function () {
    // アップロード関連
    Route::middleware('can:admin_corporations')->group(function () {
        Route::get('/show-upload', [CorporationController::class, 'showUploadForm'])->name('showUploadForm');
        Route::post('/upload', [CorporationController::class, 'upload'])->name('upload');
    });

    // ダウンロード関連
    Route::get('/download-csv', [CorporationController::class, 'downloadCsv'])->middleware('can:download_corporations')->name('downloadCsv');

    // 検索
    Route::post('/search', [CorporationController::class, 'search'])->name('search');

    // 基本CRUD
    Route::controller(CorporationController::class)->group(function () {
        Route::get('/', 'index')->middleware('can:view_corporations')->name('index');
        Route::get('/create', 'create')->middleware('can:storeUpdate_corporations')->name('create');
        Route::post('/', 'store')->middleware('can:storeUpdate_corporations')->name('store');
        Route::get('/{corporation}/edit', 'edit')->middleware('can:view_corporations')->name('edit');
        Route::put('/{corporation}', 'update')->middleware('can:storeUpdate_corporations')->name('update');
        Route::delete('/{corporation}', 'destroy')->middleware('can:delete_corporations')->name('destroy');
        Route::post('/corporations/bulk-delete', 'bulkDelete')->middleware('can:delete_corporations')->name('bulkDelete');
    });
});