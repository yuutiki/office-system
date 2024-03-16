<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContractDetailStoreRequest;
use App\Models\Contract;
use App\Models\ContractChangeType;
use App\Models\ContractDetail;
use App\Models\ContractPartnerType;
use App\Models\ContractSheetStatus;
use App\Models\ContractType;
use App\Models\ContractUpdateType;
use Illuminate\Http\Request;

class ContractDetailController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request, $contractId)
    {
        $contractTypes = ContractType::all();
        $contractUpdateTypes = ContractUpdateType::all();
        $contractChangeTypes = ContractChangeType::all();
        $contractPartnerTypes = ContractPartnerType::all();
        $contractSheetStatuses = ContractSheetStatus::all();

        $contract = Contract::findOrFail($contractId);

        return view('contract-details.create',compact('contractTypes','contractUpdateTypes','contractChangeTypes','contractPartnerTypes','contractSheetStatuses','contract',));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ContractDetailStoreRequest $request, $contractId)
    {
        $contractDetail = new ContractDetail;

        $contractDetail->contract_id = $contractId;

        $contractDetail->contract_start_at = $request->contract_start_at;
        $contractDetail->contract_end_at = $request->contract_end_at;
        $contractDetail->contract_sheet_status_id = $request->contract_sheet_status_id;
        $contractDetail->contract_change_type_id = $request->contract_change_type_id;
        $contractDetail->contract_update_type_id = $request->contract_update_type_id;
        $contractDetail->contract_partner_type_id = $request->contract_partner_type_id;
        $contractDetail->contract_amount = $request->contract_amount;
        $contractDetail->target_system = $request->target_system;
        $contractDetail->contract_detail_memo = $request->contract_detail_memo;
        $contractDetail->project_id = $request->project_id;

        $contractDetail->save();
        
        // return redirect()->back()->with('success', '正常に登録し詳細画面に遷移しました');
        return redirect()->route('contracts.details.edit', ['contract' => $contractId, 'detail' => $contractDetail->id])->with('success', '正常に登録し詳細画面に遷移しました');
    }

    /**
     * Display the specified resource.
     */
    public function show(ContractDetail $contractDetail)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Contract $contract, ContractDetail $detail)
    {
        $contractTypes = ContractType::all();
        $contractUpdateTypes = ContractUpdateType::all();
        $contractChangeTypes = ContractChangeType::all();
        $contractPartnerTypes = ContractPartnerType::all();
        $contractSheetStatuses = ContractSheetStatus::all();

        // $contract = Contract::findOrFail($contractId);

        return view('contract-details.edit',compact('contractTypes','contractUpdateTypes','contractChangeTypes','contractPartnerTypes','contractSheetStatuses','contract','detail',));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Contract $contract, ContractDetail $detail)
    {
        $contractDetail = ContractDetail::find($detail->id);

        $contractDetail->contract_id = $contract->id;

        $contractDetail->contract_start_at = $request->contract_start_at;
        $contractDetail->contract_end_at = $request->contract_end_at;
        $contractDetail->contract_sheet_status_id = $request->contract_sheet_status_id;
        $contractDetail->contract_change_type_id = $request->contract_change_type_id;
        $contractDetail->contract_update_type_id = $request->contract_update_type_id;
        $contractDetail->contract_partner_type_id = $request->contract_partner_type_id;
        $contractDetail->contract_amount = filter_var($request->contract_amount, FILTER_SANITIZE_NUMBER_INT);
        $contractDetail->target_system = $request->target_system;
        $contractDetail->contract_detail_memo = $request->contract_detail_memo;
        $contractDetail->project_id = $request->project_id;


        $contractDetail->save();
        return redirect()->back()->with('success', '正常に登録しました');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ContractDetail $contractDetail)
    {
        //
    }
}
