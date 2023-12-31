<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KeepfileController; //add
use App\Http\Controllers\ClientCorporationController;//add
use App\Http\Controllers\ClientController;//add
use App\Http\Controllers\Dashboard\DashboardController;//add
use App\Http\Controllers\CommentController;//add
use App\Http\Controllers\LinkController;
use App\Http\Controllers\ReportController;//add
use App\Http\Controllers\ProductController;//add
use App\Http\Controllers\UserController;//add
use App\Http\Controllers\ProjectRevenueController;//add
use App\Http\Livewire\ClientCorporationSearchModal;
use App\Http\Livewire\ClientForm;
use App\Http\Controllers\Master\AccountingPeriodController;
use App\Http\Controllers\Master\AccountingTypeController;
use App\Http\Controllers\Master\ClientTypeController;
use App\Http\Controllers\Master\CompanyController;
use App\Http\Controllers\Master\ContactTypeController;
use App\Http\Controllers\Master\DepartmentController;
use App\Http\Controllers\Master\DistributionTypeController;
use App\Http\Controllers\Master\DivisionController;
use App\Http\Controllers\Master\InstallationTypeController;
use App\Http\Controllers\Master\PrefectureController;
use App\Http\Controllers\Master\ProductCategoryController;
use App\Http\Controllers\Master\ProductMakerController;
use App\Http\Controllers\Master\ProductSeriesController;
use App\Http\Controllers\Master\ProductSplitTypeController;
use App\Http\Controllers\Master\ProductTypeController;
use App\Http\Controllers\Master\ProductVersionController;
use App\Http\Controllers\Master\ProjectTypeController;
use App\Http\Controllers\Master\ReportTypeController;
use App\Http\Controllers\Master\SalesStageController;
use App\Http\Controllers\Master\SupportTimeController;
use App\Http\Controllers\Master\SupportTypeController;
use App\Http\Controllers\Master\TradeStatusController;


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
    return view('auth.login');
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
    Route::resource('/client-product' , '\App\Http\Controllers\ClientProductController');
    Route::resource('/projectrevenue' , '\App\Http\Controllers\ProjectRevenueController');
    Route::resource('/estimate' , '\App\Http\Controllers\EstimateController');

    //マスタ系
    Route::resource('/accounting-period', AccountingPeriodController::class);
    Route::resource('/accounting-type', AccountingTypeController::class);
    Route::resource('/masters', '\App\Http\Controllers\MasterController');
    Route::resource('/division', DivisionController::class);
    Route::resource('/department', DepartmentController::class);
    Route::resource('/company', CompanyController::class);
    Route::resource('/contact-type', ContactTypeController::class);
    Route::resource('/client-type', ClientTypeController::class);
    Route::resource('/distribution-type', DistributionTypeController::class);
    Route::resource('/installation-type', InstallationTypeController::class);
    Route::resource('/prefecture', PrefectureController::class);
    Route::resource('/product-maker', ProductMakerController::class);
    Route::resource('/product-category', ProductCategoryController::class);
    Route::resource('/product-type', ProductTypeController::class);
    Route::resource('/product-split-type', ProductSplitTypeController::class);
    Route::resource('/product-series', ProductSeriesController::class);
    Route::resource('/product-version', ProductVersionController::class);
    Route::resource('/project-type', ProjectTypeController::class);
    Route::resource('/report-type', ReportTypeController::class);
    Route::resource('/sales-stage', SalesStageController::class);
    Route::resource('/support-time', SupportTimeController::class);
    Route::resource('/support-type', SupportTypeController::class);
    Route::resource('/trade-status', TradeStatusController::class);
    
    
    





    // Route::resource('/comment', '\App\Http\Controllers\CommentController');
    Route::post('/clientcorporation/search', [ClientCorporationController::class, 'search'])->name('clientcorporation.search');
    Route::post('/client/search', [ClientController::class, 'search'])->name('client.search');
    Route::post('/product/search', [ProductController::class, 'search'])->name('product.search');
    Route::get('/report/{report_id}/comment', [CommentController::class, 'show'])->name('comment.show');
    Route::post('/report/{report_id}/comment', [CommentController::class, 'store'])->name('comment.store');
    Route::get('/report/{report_id}/client', [ReportController::class, 'showFromClient'])->name('report.showFromClient');
    Route::post('/bulk-insert-revenues', [ProjectRevenueController::class, 'bulkInsert'])->name('projectrevenue.bulkInsert');
    Route::delete('/bulk-delete-revenues', [ProjectRevenueController::class, 'bulkDelete'])->name('projectrevenue.bulkDelete');

// CSVアップロード系
    Route::post('/clientcorporation/upload', [ClientCorporationController::class, 'upload'])->name('clientcorporation.upload');
    Route::post('/client/upload', [ClientController::class, 'upload'])->name('client.upload');
    Route::post('/user/upload', [UserController::class, 'upload'])->name('user.upload');
    Route::post('/product/upload', [ProductController::class, 'upload'])->name('product.upload');
    Route::post('/project/upload', [ProjectController::class, 'upload'])->name('project.upload');





    Route::post('/update-link/{link}', [LinkController::class, 'mordalupdate'])->name('updateLink');
    Route::post('/save-modal-id', [LinkController::class, 'saveModalId'])->name('save.modal.id');

    //顧客編集画面のアクティブタブを取得
    Route::post('/updateActiveTab',  [ClientController::class, 'updateActiveTab']);


    // Route::get('/product-selection', 'ProductController@index');
    Route::get('/get-split-types/{productTypeId}', [ProductController::class, 'getSplitTypes'])->name('product.getSplitTypes');

});

// Route::resource('/dashboard', '\App\Http\Controllers\DashboardController')->middleware(['auth', 'verified'])->name('dashboard');
Route::get('/dashboard',  [DashboardController::class, 'index'])->name('dashboard')->middleware(['auth', 'verified']);

require __DIR__.'/auth.php';