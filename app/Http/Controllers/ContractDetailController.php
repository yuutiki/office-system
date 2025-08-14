<?php

namespace App\Http\Controllers;

use app\Common\CommonFunction;
use App\Http\Requests\ContractDetailStoreRequest;
use App\Models\Contract;
use App\Models\ContractChangeType;
use App\Models\ContractDetail;
use App\Models\ContractDetailAttachment;
use App\Models\ContractPartnerType;
use App\Models\ContractSheetStatus;
use App\Models\ContractType;
use App\Models\ContractUpdateType;
use App\Models\User;
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
        $users = User::where('employee_status_id', 1)->get();


        $contract = Contract::findOrFail($contractId);

        return view('contract-details.create',compact('contractTypes', 'contractUpdateTypes', 'contractChangeTypes', 'contractPartnerTypes', 'contractSheetStatuses', 'contract', 'users'));
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
        return redirect()->route('contracts.details.edit', ['contract' => $contractId, 'contractDetail' => $contractDetail])->with('success', '正常に登録し詳細画面に遷移しました');
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
    public function edit(Contract $contract, ContractDetail $contractDetail)
    {
        $contractTypes = ContractType::all();
        $contractUpdateTypes = ContractUpdateType::all();
        $contractChangeTypes = ContractChangeType::all();
        $contractPartnerTypes = ContractPartnerType::all();
        $contractSheetStatuses = ContractSheetStatus::all();

        // 契約詳細添付ファイルの一覧を取得
        $attachments = ContractDetailAttachment::where('contract_detail_id', $contractDetail->id)->get();

        return view('contract-details.edit',compact('contractTypes','contractUpdateTypes','contractChangeTypes','contractPartnerTypes','contractSheetStatuses','contract','contractDetail','attachments'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Contract $contract, ContractDetail $contractDetail)
    {
        // $contractDetail = ContractDetail::find($contractDetail->id);
        
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
    
        // 新しいPDFファイルがアップロードされた場合は処理する
        if ($request->hasFile('attachments')) {
            $file = $request->file('attachments');

            // オリジナルファイル名を取得
            $originalFileName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
            
            // ファイル名を生成
            $fileName = $originalFileName . '_' . $request->contract_start_at . '_' . now()->format('YmdHis') . '.pdf';


            // ファイルを保存
            $filePath = $file->storeAs('contract-details/file', $fileName, 'public');
            $fileSize = $file->getSize();

            // 契約詳細添付ファイルを登録
            $contractDetailAttachment = new ContractDetailAttachment();
            $contractDetailAttachment->contract_detail_id = $contractDetail->id;
            $contractDetailAttachment->file_path = $filePath;
            $contractDetailAttachment->file_size = $fileSize;
            $contractDetailAttachment->save();
        }
    
        return redirect()->back()->with('success', '正常に更新しました');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ContractDetail $contractDetail)
    {
        //
    }
}
