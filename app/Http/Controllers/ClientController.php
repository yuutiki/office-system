<?php

namespace App\Http\Controllers;

use App\Models\ClientCorporation;//add
use App\Models\Client;
use App\Models\ClientProduct;
use App\Models\User;
use App\Models\Department;//add
use App\Models\InstallationType;//add
use App\Models\ClientType;//add
use App\Models\TradeStatus;//add
use App\Models\Prefecture;//add
use App\Models\Report;//add
use App\Models\Support;
use Illuminate\Http\Request;
use Illuminate\pagination\paginator;//add
use Illuminate\Support\Facades\DB;//add
use Illuminate\Support\Facades\Validator;

class ClientController extends Controller
{
    public function index(Request $request)
    {
        $per_page = 25;
        $clients = Client::with(['clientCorporation'])->sortable()->orderBy('client_num','asc')->paginate($per_page); 
        $users = User::all();
        $count = $clients->count();

        return view('client.index',compact('clients','count','users'));
    }

    public function create()
    {
        $users = User::all();
        $installationTypes = InstallationType::all(); //設置種別
        $tradeStatuses = TradeStatus::all(); //取引状態
        $clientTypes = ClientType::all(); //顧客種別
        $departments = Department::all(); //管轄事業部
        $prefectures = Prefecture::all(); //都道府県

        return view('client.create',compact('departments','users','tradeStatuses','clientTypes','installationTypes','prefectures'));
    }

    public function store(Request $request)
    {
        // バリデーションの実行(Model)
        $validator = Validator::make($request->all(), Client::$rules);

        if ($validator->fails()) {
            // バリデーションエラーが発生した場合
            session()->flash('error', '入力内容にエラーがあります。');
            return redirect()->back()->withErrors($validator)->withInput();
        }

        ////以下にバリデーションを通過した場合の処理を記述////

        $inputPost = $request->head_post_code;
        $formattedPost = Client::formatPostCode($inputPost);

        // フォームからの値を変数に格納
        $clientcorporationNum = $request->input('clientcorporation_num');
        $prefix_code = $request->input('department');

        // clientcorporation_numからclientcorporation_idを取得する
        $clientcorporation = ClientCorporation::where('clientcorporation_num', $clientcorporationNum)->first();
        $clientcorporationId = $clientcorporation->id;

        $clientNumber = Client::generateClientNumber($clientcorporationNum, $prefix_code);

        // 顧客データを保存
        $client = new Client();
        $client->client_num = $clientNumber;// 採番した顧客番号をセット

        $client->client_corporation_id = $clientcorporationId;
        $client->department_name = $request->department;
        $client->client_name = $request->client_name;
        $client->client_kana_name = $request->client_kana_name;
        $client->head_post_code = $formattedPost;//変換後の郵便番号をセット
        $client->head_prefecture = $request->head_prefecture;
        $client->head_address1 = $request->head_addre1;
        $client->head_tel = $request->head_tel;
        $client->students = $request->students;
        $client->distribution = $request->distribution;
        $client->client_type_id = $request->client_type_id;
        $client->installation_type_id = $request->installation_type_id;
        $client->trade_status_id = $request->trade_status_id;
        $client->user_id = $request->user_id;
        $client->save();

        return redirect()->route('client.index')->with('success', '登録しました');
    }



    public function show(Client $client)
    {
        //
    }

    public function edit(string $id)
    {
        $users = User::all();
        $tradeStatuses = TradeStatus::all();
        $clientTypes = ClientType::all();
        $installationTypes = InstallationType::all();
        $departments = Department::all();
        $client = Client::find($id);
        $prefectures = Prefecture::all(); //都道府県

        $clientProducts = ClientProduct::where('client_id',$id)->get();
        $reports = Report::where('client_id',$id)->get();
        $supports = Support::where('client_id',$id)->get();
        return view('client.edit',compact('departments','users','tradeStatuses','clientTypes','installationTypes','client','reports','prefectures','supports','clientProducts'));
    }

    public function update(Request $request, string $id)
    {
        // バリデーションの実行(Model)
        $validator = Validator::make($request->all(), Client::$rules);

        if ($validator->fails()) {
            // バリデーションエラーが発生した場合
            session()->flash('error', '入力内容にエラーがあります。');
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $client=Client::find($id);

        $client->client_num = $request->client_num;
        $client->client_name = $request->client_name;
        $client->client_kana_name = $request->client_kana_name;
        $client->head_post_code = $request->head_post_code;
        $client->head_prefecture = $request->head_prefecture;
        $client->head_address1 = $request->head_addre1;
        $client->head_tel = $request->head_tel;
        $client->students = $request->students;
        $client->distribution = $request->distribution;
        $client->department_name = $request->department;
        $client->client_type_id = $request->client_type_id;
        $client->installation_type_id = $request->installation_type_id;
        $client->trade_status_id = $request->trade_status_id;
        $client->user_id = $request->user_id;
        $client->save();

        return redirect()->route('client.edit',$id)->with('success', '変更しました');
    }

    public function destroy(string $id)
    {
        $client = Client::find($id);
        $client->delete();

        return redirect()->route('client.index')->with('message', '削除しました');
    }

    //モーダル用の非同期検索ロジック
    public function search(Request $request)
    {
        $clientName = $request->input('clientName');
        $clientNumber = $request->input('clientNumber');
        $clientDepartment = $request->input('departmentCode');

        // 検索条件に基づいて顧客データを取得
        // $clients = Client::where('client_name', 'LIKE', '%' . $clientName . '%')
        //     ->where('client_num', 'LIKE', '%' . $clientNumber . '%')
        //     ->where('department_name', 'LIKE', '%' . $clientDepartment . '%')
        //     ->get();
        $query = Client::query()
        ->where('client_name', 'LIKE', '%' . $clientName . '%')
        ->where('client_num', 'LIKE', '%' . $clientNumber . '%')
        ->where('department_name', 'LIKE', '%' . $clientDepartment . '%');
        $clients = $query->with('products')->get();

        return response()->json($clients);
    }
}
