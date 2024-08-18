<?php

namespace App\Http\Controllers;

use App\Models\Affiliation1;
use App\Models\Affiliation2;
use App\Models\Affiliation3;
use App\Models\EstimateAddress;
use Illuminate\Http\Request;

class EstimateAddressController extends Controller
{
    public function index()
    {
        $perPage = config('constants.perPage'); // １ページごとの表示件数
        $affiliation1s = Affiliation1::all();
        $affiliation2s = Affiliation2::all();
        $affiliation3s = Affiliation3::all();

        $estimateAddresses = EstimateAddress::with('updatedBy')->orderBy('estimate_address_code', 'asc')->paginate($perPage);
        return view('masters.estimate-address-index',compact('estimateAddresses', 'affiliation1s', 'affiliation2s', 'affiliation3s'));
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show(EstimateAddress $estimateAddress)
    {
        //
    }

    public function edit(EstimateAddress $estimateAddress)
    {
        //
    }

    public function update(Request $request, EstimateAddress $estimateAddress)
    {
        // $user = Auth::user(); // ログインしているユーザーの情報を取得

        // $data = $request->all();
        // $data['updated_by'] = $user->id; // 更新者のIDを更新データに追加
    
        $estimateAddress->fill($request->all())->save();
    
        return redirect()->back()->with('success', '正常に更新しました');
    }

    public function destroy(EstimateAddress $estimateAddress)
    {
        //
    }
}
