<?php

use App\Http\Controllers\AppSettingController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KeepfileController; //add
use App\Http\Controllers\CorporationController;//add
use App\Http\Controllers\ClientController;//add
use App\Http\Controllers\ClientPersonController;
use App\Http\Controllers\Dashboard\DashboardController;//add
use App\Http\Controllers\CommentController;//add
use App\Http\Controllers\ContractController;
use App\Http\Controllers\ContractDetailController;
use App\Http\Controllers\EstimateController;
use App\Http\Controllers\LinkController;
use App\Http\Controllers\ReportController;//add
use App\Http\Controllers\ProductController;//add
use App\Http\Controllers\UserController;//add
use App\Http\Controllers\ProjectRevenueController;//add
use App\Http\Livewire\ClientCorporationSearchModal;
use App\Http\Livewire\ClientForm;
use App\Http\Controllers\Master\AccountingPeriodController;
use App\Http\Controllers\Master\AccountingTypeController;
use App\Http\Controllers\Master\Affiliation1Controller;
use App\Http\Controllers\Master\Affiliation2Controller;
use App\Http\Controllers\Master\Affiliation3Controller;
use App\Http\Controllers\Master\ClientTypeController;
use App\Http\Controllers\Master\ContactTypeController;
use App\Http\Controllers\Master\DistributionTypeController;
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
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\RoleGroupController;
use App\Http\Controllers\SupportController;
use App\Http\Controllers\VendorController;
use App\Models\Contract;
use App\Http\Controllers\Auth\PasswordChangeController;
use App\Http\Controllers\ClientSearchModalDisplayItemController;
use App\Http\Controllers\CorporationCreditController;
use App\Http\Controllers\EstimateAddressController;
use App\Http\Controllers\ModelHistoryController;
use App\Http\Controllers\PasswordPolicyController;
use App\Http\Controllers\ProjectExpenseController;
use App\Http\Controllers\UserSettingsController;
use App\Models\EstimateAddress;
use Illuminate\Foundation\Http\Middleware\HandlePrecognitiveRequests;


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


Route::middleware(['auth'])->group(function () {

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::put('/profile', [ProfileController::class, 'updateImage'])->name('profile.updateImage');

    // Projects関連
    Route::get('/projects/show-upload', [ProjectController::class, 'showUploadForm'])->name('projects.showUploadForm');
    Route::post('/projects/search', [ProjectController::class, 'search'])->name('projects.search');
    Route::post('/projects/upload', [ProjectController::class, 'upload'])->name('projects.upload');
    Route::resource('/projects', ProjectController::class);

    // ProjectExpenses関連
    // Route::get('/project-expense/show-upload', [ProjectExpenseController::class, 'showUploadForm'])->name('project-expense.showUploadForm');
    // Route::post('/project-expense/search', [ProjectExpenseController::class, 'search'])->name('project-expense.search');
    // Route::post('/project-expense/upload', [ProjectExpenseController::class, 'upload'])->name('project-expense.upload');
    Route::resource('/project-expense', ProjectExpenseController::class);

    // // corporations関連
    // // 1. 特別な権限が必要なルート
    // Route::middleware(['can:admin_corporations'])->group(function () {
    //     Route::get('/corporations/show-upload', [CorporationController::class, 'showUploadForm'])->name('corporations.showUploadForm');
    //     Route::post('/corporations/upload', [CorporationController::class, 'upload'])->name('corporations.upload');
    // });


    // Route::middleware(['can:download_corporations'])->group(function () {
    //     Route::get('/corporations/download-csv', [CorporationController::class, 'downloadCsv'])->name('corporations.downloadCsv');
    // });


    // Route::post('/corporations/search', [CorporationController::class, 'search'])->name('corporations.search');

    // // 3. 基本CRUDルート（個別に権限設定）
    // Route::get('/corporations', [CorporationController::class, 'index'])
    //     ->middleware('can:view_corporations')
    //     ->name('corporations.index');

    // Route::get('/corporations/create', [CorporationController::class, 'create'])
    //     ->middleware('can:storeUpdate_corporations')
    //     ->name('corporations.create');

    // Route::post('/corporations', [CorporationController::class, 'store'])
    //     ->middleware('can:storeUpdate_corporations')
    //     ->name('corporations.store');

    // Route::get('/corporations/{corporation}/edit', [CorporationController::class, 'edit'])
    //     ->middleware('can:view_corporations')
    //     ->name('corporations.edit');

    // Route::put('/corporations/{corporation}', [CorporationController::class, 'update'])
    //     ->middleware('can:storeUpdate_corporations')
    //     ->name('corporations.update');

    // Route::delete('/corporations/{corporation}', [CorporationController::class, 'destroy'])
    //     ->middleware('can:delete_corporations')
    //     ->name('corporations.destroy');

    // Route::resource('/corporations', CorporationController::class);

    // corporationCredits関連
    Route::resource('/corporation-credits', CorporationCreditController::class);

    // clients関連
    Route::get('/clients/show-upload', [ClientController::class, 'showUploadForm'])->name('clients.showUploadForm');
    Route::post('/clients/upload', [ClientController::class, 'upload'])->name('clients.upload');
    Route::post('/client/search', [ClientController::class, 'search'])->name('client.search');
    Route::resource('/clients', ClientController::class);
    Route::post('/updateActiveTab',  [ClientController::class, 'updateActiveTab']); //顧客編集画面のアクティブタブを取得

    // clientPerson関連
    Route::get('/client-person/show-upload', [ClientPersonController::class, 'showUploadForm'])->name('client-person.showUploadForm');
    Route::post('/client-person/upload', [ClientPersonController::class, 'upload'])->name('client-person.upload');
    Route::resource('/client-person', ClientPersonController::class);

    // vendor関連
    Route::get('/vendors/show-upload', [VendorController::class, 'showUploadForm'])->name('vendors.showUploadForm');
    Route::post('/vendors/upload', [VendorController::class, 'upload'])->name('vendors.upload');
    Route::post('/vendors/search', [VendorController::class, 'search'])->name('vendors.search');
    Route::resource('/vendors',VendorController::class);

    // keepfile関連
    Route::delete('/keepfiles/{id}/delete-pdf', [KeepfileController::class, 'deletePdf'])->name('keepfile.deletePdf');
    Route::resource('/keepfiles',KeepfileController::class);

    // user関連
    Route::post('/users/add-role-group', [UserController::class, 'addGroupsToUser'])->name('users.add-role-groups');
    Route::get('/users/show-upload', [UserController::class, 'showUploadForm'])->name('users.showUploadForm');
    Route::post('/users/upload', [UserController::class, 'upload'])->name('users.upload');
    Route::get('/search-users', [UserController::class, 'searchUsers']);
    Route::resource('/users', UserController::class);

    // product関連
    Route::get('/products/show-upload', [ProductController::class, 'showUploadForm'])->name('products.showUploadForm');
    Route::post('/products/upload', [ProductController::class, 'upload'])->name('products.upload');
    Route::post('/products/search', [ProductController::class, 'search'])->name('products.search');
    Route::get('/get-split-types/{productTypeId}', [ProductController::class, 'getSplitTypes'])->name('products.getSplitTypes');
    Route::resource('/products', ProductController::class);

    // support関連
    Route::get('/supports/show-upload', [SupportController::class, 'showUploadForm'])->name('supports.showUploadForm');
    Route::post('/supports/upload', [SupportController::class, 'upload'])->name('supports.upload');
    Route::get('supports/create/{client}', [SupportController::class, 'createFromClient'])->name('supports.createFromClient')->whereNumber('client'); // 顧客からの新規作成ルート,clientのIDが数値であることを保証
    Route::resource('/supports', '\App\Http\Controllers\SupportController');

    // repport関連
    Route::get('/report/{report_id}/comment', [CommentController::class, 'show'])->name('comment.show');
    Route::post('/report/{report_id}/comment', [CommentController::class, 'store'])->name('comment.store');

    Route::get('/report/{report_id}/client', [ReportController::class, 'showFromClient'])->name('report.showFromClient');
    Route::prefix('reports')->group(function () {
        // 通常の新規作成ルート
        Route::get('/create', [ReportController::class, 'create'])
            ->name('reports.create');
    
        // 顧客からの新規作成ルート
        Route::get('/create/{client}', [ReportController::class, 'createFromClient'])
            ->name('reports.createFromClient')
            ->whereNumber('client'); // clientのIDが数値であることを保証
    
        // 保存処理用のルート（共通）
        Route::post('/', [ReportController::class, 'store'])
            ->name('reports.store');
    });
    Route::resource('/reports', ReportController::class);


    // RoleGroup
    Route::post('/groups/add-users', [RoleGroupController::class, 'addUsersToGroup'])->name('role-groups.add-users');
    Route::delete('/group/delete-user', [RoleGroupController::class, 'deleteUserFromGroup'])->name('group.delete_user');
    Route::get('/search-role-groups', [RoleGroupController::class, 'searchRoleGroups']);
    Route::resource('role-groups', RoleGroupController::class);


    // ユーザー別の一覧表示項目の設定
    Route::post('/user-settings/columns', [UserSettingsController::class, 'saveColumnSettings'])->name('user-settings.columns');



    // contract-detail 関連
    Route::get('contracts/{contract}/details/create', [ContractDetailController::class, 'create'])->name('contracts.details.create');
    Route::post('contracts/{contract}/details/store', [ContractDetailController::class, 'store'])->name('contracts.details.store');
    Route::get('contracts/{contract}/details/{contractDetail}/edit', [ContractDetailController::class, 'edit'])->name('contracts.details.edit');
    // Route::put('/contracts/{contract}/details/{detail}', [ContractDetailController::class, 'update'])->name('contracts.details.update');
    Route::put('contracts/{contract}/details/{contractDetail}', [ContractDetailController::class, 'update'])->name('contracts.details.update');
    Route::resource('/contracts', ContractController::class);


    // estimate（見積）
    // Route::group(['prefix' => 'projects/{projectId}/estimates'], function () {
    //     Route::get('{estimateId}/edit', [EstimateController::class, 'edit'])->name('estimates.edit');
    //     Route::put('{estimateId}', [EstimateController::class, 'update'])->name('estimates.update');
    //     // Route::get('{estimateId}', [EstimateController::class, 'show'])->name('estimates.show');
    // });
    Route::get('/estimate/{projectId}/{estimateId}/edit', [EstimateController::class, 'edit'])->name('estimates.edit');
    Route::patch('/estimate/{projectId}/{estimateId}/update', [EstimateController::class, 'update'])->name('estimates.update');
    Route::get('/estimate/{estimate}/pdf', [EstimateController::class, 'generatePdf'])->name('estimate.pdf.preview');
    Route::get('/estimates/{estimate}/pdf/download', [EstimateController::class, 'downloadPdf'])->name('estimates.pdf.download');
    Route::get('estimate/{project}/create', [EstimateController::class, 'create'])->name('estimate.create');
    Route::delete('estimate/{estimate}/delete', [EstimateController::class, 'destroy'])->name('estimate.destroy');
    Route::post('estimate/{project}/store', [EstimateController::class, 'store'])->name('estimate.store');
    // Route::resource('/estimate' , EstimateController::class);

    // notification
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::post('/notifications/{notification}/read', [NotificationController::class, 'read'])->name('notifications.read');
    Route::post('/notifications/read-all', [NotificationController::class, 'readAll'])->name('notifications.read-all');

    // Route::post('api/links/update', [LinkController::class, 'update'])
    // ->middleware(HandlePrecognitiveRequests::class)
    // ->name('api.links.update');

    Route::put('/api/links/{link}/update', [LinkController::class, 'update'])
    ->middleware(HandlePrecognitiveRequests::class)
    ->name('api.links.update');


    Route::resource('/link', '\App\Http\Controllers\LinkController');
    Route::resource('/client-product' , '\App\Http\Controllers\ClientProductController');
    Route::resource('/projectrevenue' , '\App\Http\Controllers\ProjectRevenueController');


    // Route::post('/api/client-search', [ClientSearchModalDisplayItemController::class, 'search'])->name('api.client.search');



    // サポート履歴入力画面にて非同期で顧客情報を取得するエンドポイント
    Route::get('/api/client/{clientId}', [ClientController::class, 'getClientInfo'])->name('api.client.info');






    //マスタ系
    Route::resource('/masters', '\App\Http\Controllers\AppMasterController');
    Route::resource('/accounting-period', AccountingPeriodController::class);
    Route::resource('/accounting-type', AccountingTypeController::class);
    Route::resource('/affiliation3', Affiliation3Controller::class);
    Route::resource('/affiliation2', Affiliation2Controller::class);
    Route::resource('/affiliation1', Affiliation1Controller::class);
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

    Route::get('/support-type/export',[SupportTypeController::class,'export'])->name('support-types.export');
    Route::resource('/support-type', SupportTypeController::class);
    Route::resource('/trade-status', TradeStatusController::class);
    Route::resource('/estimate-address', EstimateAddressController::class);

    
    Route::get('/model-logs', [ModelHistoryController::class, 'index'])->name('logs.index');
    Route::get('/model-logs/{modelHistory}', [ModelHistoryController::class, 'show'])->name('logs.show');

    // Route::resource('/comment', '\App\Http\Controllers\CommentController');

    Route::post('/bulk-insert-revenues', [ProjectRevenueController::class, 'bulkInsert'])->name('projectrevenue.bulkInsert');
    Route::delete('/bulk-delete-revenues', [ProjectRevenueController::class, 'bulkDelete'])->name('projectrevenue.bulkDelete');


    // Route::post('/update-link/{link}', [LinkController::class, 'mordalupdate'])->name('updateLink');
    // Route::post('/save-modal-id', [LinkController::class, 'saveModalId'])->name('save.modal.id');
    // Route::get('/corporations/export', [CorporationController::class, 'exportCsv'])->name('corporations.export');
    // Route::get('/corporations/download/{filename}', [CorporationController::class, 'downloadCsv'])->name('corporations.download');

    Route::resource('/password-policy', PasswordPolicyController::class);

    // routes/web.php

    Route::resource('/app-settings', AppSettingController::class);
    // Route::resource('/affiliation-level-settings', AppSettingController::class);
    // Route::resource('/app-settings', AppSettingController::class);

    Route::get('/licenses', function () {
        return view('licenses');
     });


});

// Route::get('/dashboard',  [DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');
Route::get('/dashboard',  [DashboardController::class, 'index'])->name('dashboard')->middleware('auth');

require __DIR__.'/auth.php';