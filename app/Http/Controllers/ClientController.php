<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;
use App\Models\ClientCorporation;//add
use Illuminate\pagination\paginator;//add

class ClientController extends Controller
{
    public function index(Request $request)
    {
        $clients = Client::with(['clientCorporation'])->sortable()->orderBy('client_num','asc')->paginate(15); 

        return view('client.index',compact('clients'));
    }

    public function create()
    {
        return view('client.create');
    }

    public function store(Request $request)
    {
        // フォームからの値を取得
        $clientcorporationNum = $request->input('clientcorporation_num');
        $clientName = $request->input('client_name');
        $clientKanaName = $request->input('client_kana_name');

        // 顧客法人を取得
        $clientcorporation = ClientCorporation::where('clientcorporation_num', $clientcorporationNum)->first();

        // 顧客番号を生成
        $clientcorporationId = $clientcorporation->id;
        $clientNumber = Client::generateClientNumber($clientcorporationId);

        // 顧客を保存
        $client = new Client([
            'client_corporation_id' => $clientcorporationId,
            'client_num' => $clientNumber,
            'client_name' => $clientName,
            'client_kana_name' => $clientKanaName,
        ]);
        $client->save();

        return redirect()->route('client.create')->with('message', '登録しました');
    }

    public function show(Client $client)
    {
        //
    }

    public function edit(Client $client)
    {
        $inputs=$request->validate([
            'client_num'=>'required|min:2|max:2',
            'client_name'=>'required|max:1024',
            'client_kana_name'=>'required|max:1024',
            'clientcorporation_id'=>'required|max:1024'
        ]);

        $client = new Client();
        $clientcorporattion = new ClientCorporation();
        // $var = client::with('client_corporate')->where('id',$id)->first();
        $id = 
        $client->clientcorporation_num=$request->clientcorporation_num;
        $client->client_num=$request->client_num;
        $client->client_name = $request->client_name;
        $client->client_kana_name = $request->client_kana_name;
        $client->clientcorporattion_id = ClientCorporation::select('client_corporate_id')->where('id',$id)->first();
        $client->save();
        return redirect()->route('client.create')->with('val',$val,'message', '変更しました');
    }

    public function update(Request $request, Client $client)
    {
        //
    }

    public function destroy(Client $client)
    {
        //
    }

    public function searchClientCorporations(Request $request)
    {
        $searchTerm = $request->input('search_term');
        $clientCorporations = ClientCorporation::where('clientcorporation_num', 'like', '%' . $searchTerm . '%')
            ->orWhere('clientcorporation_name', 'like', '%' . $searchTerm . '%')
            ->get();

        return view('clientcorporation.search', compact('clientCorporations'));
    }
}
