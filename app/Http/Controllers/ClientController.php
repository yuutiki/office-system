<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;
use App\Models\ClientCorporation;//add
use Illuminate\pagination\paginator;//add

class ClientController extends Controller
{
    public function index()
    {
        //sortableとpaginateを組み合わせる際の記述
        $clients = Client::paginate(15); 
        // $keepdatas = keepdata::orderBy('returndate','asc')->get();　//sortableを使わずに無理やり並べ替える際の記述
        // $keepdatas = keepdata::paginate(10); //paginate単体利用時の記述
        return view('client.index',compact('clients'));
    }

    public function create()
    {
        return view('client.create');
    }

    public function store(Request $request)
    {
        $client = new client();
        $client->clientcorporation_num = $request->input('clientcorporation_num');
        $client->clientcorporation_name = $request->input('clientcorporation_name');
        $client->client_num=$request->client_num;
        $client->client_name = $request->client_name;
        $client->client_kana_name = $request->client_kana_name;
        $client->save();

        return redirect()->route('client.create')->with('success', '登録しました。');
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
            'client_corporation_id'=>'required|max:1024'
        ]);

        $client = new Client();
        $clientcorporattion = new ClientCorporation();
        // $var = client::with('client_corporate')->where('id',$id)->first();
        $id = 
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
