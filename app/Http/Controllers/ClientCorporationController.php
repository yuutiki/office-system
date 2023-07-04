<?php

namespace App\Http\Controllers;

use App\Models\ClientCorporation;
use Illuminate\Http\Request;
use App\Models\Client; //add
use illuminate\pagination\paginator; //add

class ClientCorporationController extends Controller
{
    public function index()
    {
        //sortableとpaginateを組み合わせる際の記述
        $clientcorporations = ClientCorporation::sortable()->paginate(15); 
        return view('clientcorporation.index',compact('clientcorporations'));
    }

    public function create()
    {
        return view('clientcorporation.create');
    }

    public function store(Request $request)
    {
        $inputs=$request->validate([
            'clientcorporation_num'=>'|min:6|max:6|unique:client_corporations',
            'clientcorporation_name'=>'required|max:1024',
            'clientcorporation_kana_name'=>'required|max:1024'
        ]);

        $data = $request->except('clientcorporation_num');

        $clientcorporation = new ClientCorporation();
        $result = $clientcorporation->storeWithTransaction($data);

        if ($result) {
            return redirect()->route('clientcorporation.index')->with('success', '登録しました');
        } else {
            return back()->with('error', '登録に失敗しました。');
        }

        // $clientcorporation->clientcorporation_num=$request->clientcorporation_num;
        $clientcorporation->clientcorporation_name = $request->clientcorporation_name;
        $clientcorporation->clientcorporation_kana_name = $request->clientcorporation_kana_name;
        $clientcorporation->save();
        return redirect()->route('clientcorporation.create')->with('message', '登録しました');
    }

    public function show(ClientCorporation $clientCorporation)
    {
        //
    }

    public function edit(ClientCorporation $clientCorporation)
    {
        //
    }

    public function update(Request $request, ClientCorporation $clientCorporation)
    {
        //
    }

    public function destroy(ClientCorporation $clientCorporation)
    {
        //
    }

    public function search(Request $request)
    {
        $corporationName = $request->input('corporationName');
        $corporationNumber = $request->input('corporationNumber');

        // 検索条件に基づいて法人データを取得
        $corporations = ClientCorporation::where('clientcorporation_name', 'LIKE', '%' . $corporationName . '%')
            ->where('clientcorporation_num', 'LIKE', '%' . $corporationNumber . '%')
            ->get();

        return response()->json($corporations);
    }


}
