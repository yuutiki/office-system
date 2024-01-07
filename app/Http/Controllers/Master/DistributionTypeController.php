<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\DistributionType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DistributionTypeController extends Controller
{
    public function index()
    {
        $distributionTypes = DistributionType::with('updatedBy')->paginate(50);
        return view('masters.distribution-type-index',compact('distributionTypes'));
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show(DistributionType $distributionType)
    {
        //
    }

    public function edit(DistributionType $distributionType)
    {
        //
    }

    public function update(Request $request, DistributionType $distributionType)
    {
        $user = Auth::user(); // ログインしているユーザーの情報を取得

        $data = $request->all();
        $data['updated_by'] = $user->id; // 更新者のIDを更新データに追加
    
        $distributionType->fill($data)->save();
    
        return redirect()->back()->with('success', '正常に更新しました');
    }

    public function destroy(DistributionType $distributionType)
    {
        //
    }
}
