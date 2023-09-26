<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\ClientType;
use App\Models\Department;
use App\Models\InstallationType;
use App\Models\ProductCategory;
use App\Models\ProductSeries;
use App\Models\ProductVersion;
use App\Models\Support;
use App\Models\SupportTime;
use App\Models\SupportType;
use App\Models\TradeStatus;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class SupportController extends Controller
{
    public function index(Request $request)
    {
        $per_page = 500;
        $supports = Support::all();
        $clients = Client::all();
        $users = User::all();  //受付対応者用
        $productSeriess = ProductSeries::all();  //製品シリーズ
        $productVersions = ProductVersion::all();  //製品バージョン
        $productCategories = ProductCategory::all();  // 製品系統
        $supportTypes = SupportType::all(); //サポート種別
        $supportTimes = SupportTime::all(); //サポート所要時間

        $query = Support::query();

        $count = $query->count(); // 検索結果の総数を取得
        $supports = $query->sortable()->paginate($per_page);

        return view('support.index',compact('users','productSeriess','productVersions','productCategories','supportTypes','supportTimes','clients','count','supports'));
    }

    public function create()
    {
        $users = User::all();  //受付対応者用
        $productSeriess = ProductSeries::all();  //製品シリーズ
        $productVersions = ProductVersion::all();  //製品バージョン
        $productCategories = ProductCategory::all();  // 製品系統
        $supportTypes = SupportType::all(); //サポート種別
        $supportTimes = SupportTime::all(); //サポート所要時間
        $installationTypes = InstallationType::all();
        $clientTypes = ClientType::all();
        $departments = Department::all();


        return view('support.create',compact('users','productSeriess','productVersions','productCategories','supportTypes','supportTimes','installationTypes','clientTypes','departments'));
    }

    public function store(Request $request)
    {

        // バリデーションの実行(Model)
        $validator = Validator::make($request->all(), Support::$rules);

        if ($validator->fails()) {
            // バリデーションエラーが発生した場合
            session()->flash('error', '入力内容にエラーがあります。');
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // フォームからの値を変数に格納
        $clientNum = $request->input('client_num');
        
        // client_numからclient_idを取得する
        $client = Client::where('client_num', $clientNum)->first();
        $clientId = $client->id;

        //問合せ連番を採番
        $requestNumber = Support::generateRequestNumber($clientId);

        // サポート履歴データを保存
        $support = new Support();
        $support->client_id = $clientId; // 予めclient_numから取得したclient_idをセット
        $support->request_num = $requestNumber;// 採番した問合せ連番をセット
        $support->received_at = $request->f_received_at;
        $support->title = $request->f_title;
        $support->request_content = $request->f_request_content;
        $support->response_content = $request->f_response_content;
        $support->internal_message = $request->f_internal_message;
        $support->internal_memo1 = $request->f_internal_memo1;
        $support->support_type_id = $request->f_support_type_id;
        $support->support_time_id = $request->f_support_time_id;
        $support->user_id = $request->f_user_id;// 受付対応者
        $support->client_user_department = $request->f_client_user_department;
        $support->client_user_kana_name = $request->f_client_user_kana_name;
        $support->product_series_id = $request->f_product_series_id;
        $support->product_version_id = $request->f_product_version_id;
        $support->product_category_id = $request->f_product_category_id;
        $support->is_finished = $request->has('f_is_finished') ? 1 : 0;
        $support->is_disclosured = $request->has('f_is_disclosured') ? 1 : 0;
        $support->is_confirmed = $request->has('f_is_confirmed') ? 1 : 0;
        $support->is_troubled = $request->has('f_is_troubled') ? 1 : 0;
        $support->is_faq_target = $request->has('f_is_faq_target') ? 1 : 0;
        $support->save();

        return redirect()->route('support.index')->with('message', '登録しました');
    }

    public function show(Support $support)
    {
        //
    }

    public function edit(string $id)
    {
        // $clients = Client::all();
        $users = User::all();
        $tradeStatuses = TradeStatus::all();
        $clientTypes = ClientType::all();
        $installationTypes = InstallationType::all();
        $departments = Department::all();
        $productSeriess = ProductSeries::all();  //製品シリーズ
        $productVersions = ProductVersion::all();  //製品バージョン
        $productCategories = ProductCategory::all();  // 製品系統
        $supportTypes = SupportType::all(); //サポート種別
        $supportTimes = SupportTime::all(); //サポート所要時間

        $support = Support::find($id);

        return view('support.edit',compact('users','tradeStatuses','clientTypes','installationTypes','departments','support','productSeriess','productVersions','productCategories','supportTypes','supportTimes'));
    }

    public function update(Request $request, string $id)
    {

        $support = Support::find($id);
        $support->received_at = $request->f_received_at;
        $support->title = $request->f_title;
        $support->request_content = $request->f_request_content;
        $support->response_content = $request->f_response_content;
        $support->internal_message = $request->f_internal_message;
        $support->internal_memo1 = $request->f_internal_memo1;
        $support->support_type_id = $request->f_support_type_id;
        $support->support_time_id = $request->f_support_time_id;
        $support->user_id = $request->f_user_id;// 受付対応者
        $support->client_user_department = $request->f_client_user_department;
        $support->client_user_kana_name = $request->f_client_user_kana_name;
        $support->product_series_id = $request->f_product_series_id;
        $support->product_version_id = $request->f_product_version_id;
        $support->product_category_id = $request->f_product_category_id;
        $support->is_finished = $request->f_is_finished;
        $support->is_disclosured = $request->f_is_disclosured;
        $support->is_confirmed = $request->f_is_confirmed;
        $support->is_troubled = $request->f_is_troubled;
        $support->is_faq_target = $request->f_is_faq_target;
        $support->save();

        return redirect()->route('support.edit',$id)->with('success', '変更しました');
    }

    public function destroy(Support $support)
    {
        //
    }

    //モーダル用の非同期検索ロジック
    // public function search(Request $request)
    // {
    //     $clientName = $request->input('clientName');
    //     $clientNumber = $request->input('clientNumber');

    //     // 検索条件に基づいて顧客データを取得
    //     $clients = Client::where('client_name', 'LIKE', '%' . $clientName . '%')
    //         ->where('client_num', 'LIKE', '%' . $clientNumber . '%')
    //         ->get();

    //     return response()->json($clients);
    // }
}
