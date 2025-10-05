<?php

namespace App\Http\Controllers;

use App\Models\Affiliation1;
use App\Models\Affiliation2;
use App\Models\Affiliation3;
use App\Models\Department;
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
        $departments = Department::getTreeStructure();

        $estimateAddresses = EstimateAddress::with('updatedBy')->orderBy('estimate_address_code', 'asc')->paginate($perPage);

        return view('masters.estimate-address-index',compact('departments', 'estimateAddresses', 'affiliation1s', 'affiliation2s', 'affiliation3s'));
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'estimate_address_code' => 'nullable',
            'estimate_address_name' => 'nullable',
            'estimate_address_1' => 'nullable',
            'estimate_address_2' => 'nullable',
            'estimate_address_3' => 'nullable',
            'estimate_address_tel' => 'nullable',
            'estimate_address_fax' => 'nullable',
            'estimate_address_mail' => 'nullable',
            'estimate_address_url' => 'nullable',
            'project_affiliation1' => 'nullable',
            'project_affiliation2' => 'nullable',
            'project_affiliation3' => 'nullable',
            'project_department_id' => 'nullable',
            'is_active' => 'nullable',
        ]);

        $estimateAddress = new EstimateAddress();
        $estimateAddress->fill($data)->save();
    
        return redirect()->back()->with('success', '正常に更新しました');
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

        $data = $request->validate([
            'estimate_address_code' => 'nullable',
            'estimate_address_name' => 'nullable',
            'estimate_address_1' => 'nullable',
            'estimate_address_2' => 'nullable',
            'estimate_address_3' => 'nullable',
            'estimate_address_tel' => 'nullable',
            'estimate_address_fax' => 'nullable',
            'estimate_address_mail' => 'nullable',
            'estimate_address_url' => 'nullable',
            'project_affiliation1' => 'nullable',
            'project_affiliation2' => 'nullable',
            'project_affiliation3' => 'nullable',
            'project_department_id' => 'nullable',
            'is_active' => 'nullable',
        ]);

    
        $estimateAddress->fill($data)->save();
    
        return redirect()->back()->with('success', '正常に更新しました');
    }

    public function destroy(EstimateAddress $estimateAddress)
    {
        //
    }
}
