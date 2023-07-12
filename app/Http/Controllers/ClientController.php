<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\User;
use App\Models\Department;//add
use App\Models\InstallationType;//add
use App\Models\ClientType;//add
use App\Models\TradeStatus;//add
use Illuminate\Http\Request;
use App\Models\ClientCorporation;//add
use Illuminate\pagination\paginator;//add
use Illuminate\Support\Facades\DB;//add
use Illuminate\Support\Str;//add

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
        $tradeStatuses = TradeStatus::all();
        $clientTypes = ClientType::all();
        $installationTypes = InstallationType::all();
        $departments = Department::all();

        return view('client.create',compact('departments','users','tradeStatuses','clientTypes','installationTypes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'clientcorporation_num' => 'required',
            'department' => 'required',
        ]);

        // フォームからの値を変数に格納
        $clientcorporationNum = $request->input('clientcorporation_num');
        $prefix_code = $request->input('department');

        // clientcorporation_numからclientcorporation_idを取得する
        $clientcorporation = ClientCorporation::where('clientcorporation_num', $clientcorporationNum)->first();
        $clientcorporationId = $clientcorporation->id;

        // DB::beginTransaction();
        // try{
            $clientNumber = $this->generateClientNumber($clientcorporationNum, $prefix_code);

            // 顧客データを保存
            $client = new Client();
            $client->client_corporation_id = $clientcorporationId;
            $client->department_name = $request->department;
            $client->client_name = $request->client_name;
            $client->client_kana_name = $request->client_kana_name;
            $client->client_num = $clientNumber;// 採番した顧客番号をセット
            $client->head_post_code = $request->head_post_code;
            $client->head_prefecture = $request->head_prefecture;
            $client->head_address1 = $request->head_addre1;
            $client->head_address2 = $request->head_addre2;
            $client->head_address3 = $request->head_addre3;
            $client->head_tel = $request->head_tel;
            $client->students = $request->students;
            $client->distribution = $request->distribution;
            $client->client_type_id = $request->client_type_id;
            $client->installation_type_id = $request->installation_type_id;
            $client->trade_status_id = $request->trade_status_id;
            $client->user_id = $request->user_id;
            $client->save();

            // トランザクションコミット
            DB::commit();

            return redirect()->route('client.index')->with('message', '登録しました');
        }
    //     catch (\Exception $e) {
    //         // エラーが発生した場合はロールバック
    //         DB::rollback();
    //         return back()->with('error', '失敗しました');
    //     }
    // }

    private function generateClientNumber($clientcorporationNum, $prefix_code)
    {
        $suffix = strtoupper(Str::substr($prefix_code, 0, 1));
        $lastClient = Client::where('client_num', 'like', "$clientcorporationNum-$suffix%")
            ->orderBy('client_num', 'desc')
            ->first();

        if ($lastClient) {
            $lastSerialNumber = (int) Str::substr($lastClient->client_num, -2);
            $newSerialNumber = str_pad($lastSerialNumber + 1, 2, '0', STR_PAD_LEFT);
        } else {
            $newSerialNumber = '01';
        }

        return "$clientcorporationNum-$suffix$newSerialNumber";
    }



    //     // フォームからの値を取得
    //     $clientcorporationNum = $request->input('clientcorporation_num');
    //     $clientName = $request->input('client_name');
    //     $clientKanaName = $request->input('client_kana_name');

    //     // 顧客法人を取得
    //     $clientcorporation = ClientCorporation::where('clientcorporation_num', $clientcorporationNum)->first();

    //     // 顧客番号を生成
    //     $clientcorporationId = $clientcorporation->id;
    //     $clientNumber = Client::generateClientNumber($clientcorporationId);

    //     // 顧客を保存
    //     $client = new Client([
    //         'client_corporation_id' => $clientcorporationId,
    //         'client_num' => $clientNumber,
    //         'client_name' => $clientName,
    //         'client_kana_name' => $clientKanaName,
    //     ]);
    //     $client->save();

    //     return redirect()->route('client.create')->with('message', '登録しました');
    // }

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
        return view('client.edit',compact('departments','users','tradeStatuses','clientTypes','installationTypes','client'));
    }

    public function update(Request $request, string $id)
    {
                // $inputs=$request->validate([
        //     'client_num'=>'required|min:2|max:2',
        //     'client_name'=>'required|max:1024',
        //     'client_kana_name'=>'required|max:1024',
        //     'client_corporation_id'=>'required|max:1024'
        // ]);

        $client=Client::find($id);

        $clientcorporattion = new ClientCorporation();
        // $client->clientcorporation_num=$request->clientcorporation_num;
        $client->client_num=$request->client_num;
        $client->client_name = $request->client_name;
        $client->client_kana_name = $request->client_kana_name;
        $client->head_post_code = $request->head_post_code;
        $client->head_prefecture = $request->head_prefecture;
        $client->head_address1 = $request->head_addre1;
        
        $client->head_address2 = $request->head_addre2;
        $client->head_address3 = $request->head_addre3;
        $client->head_tel = $request->head_tel;
        $client->students = $request->students;
        $client->distribution = $request->distribution;
        $client->client_type_id = $request->client_type_id;
        $client->installation_type_id = $request->installation_type_id;
        $client->trade_status_id = $request->trade_status_id;
        $client->user_id = $request->user_id;
        // $client->clientcorporattion_id = ClientCorporation::select('client_corporate_id')->where('id',$id)->first();
        $client->save();
        return redirect()->route('client.create')->with('message', '変更しました');
    }

    public function destroy(Client $client)
    {
        //
    }
}
