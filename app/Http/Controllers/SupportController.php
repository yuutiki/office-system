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
use App\Models\User;
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
        $request->validate([
            'client_num' => 'required',
            'f_received_at' =>  'required',
            'f_title' => 'required',
            'f_support_type_id' => 'required',
            'f_support_time_id' => 'required',
            'f_user_id' => 'required',
            'f_product_series_id' => 'required',
            'f_product_version_id' => 'required',
            'f_product_category_id' => 'required',
        ]);

        // フォームからの値を変数に格納
        $clientNum = $request->input('client_num');
        
        // client_numからclient_idを取得する
        $client = Client::where('client_num', $clientNum)->first();
        $clientId = $client->id;

        //問合せ連番を採番
        $requestNumber = Support::generateRequestNumber($clientNum);

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

    public function edit(Support $support)
    {
        //
    }

    public function update(Request $request, Support $support)
    {
        //
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
