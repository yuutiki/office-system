<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Contract;
use App\Models\ContractChangeType;
use App\Models\ContractDetail;
use App\Models\ContractPartnerType;
use App\Models\ContractSheetStatus;
use App\Models\ContractType;
use App\Models\ContractUpdateType;
use App\Models\Department;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ContractController extends Controller
{
    public function index()
    {
        $contracts = Contract::all();
        $count = $contracts->count();


        return view('contracts.index', compact('contracts','count'));
    }

    public function create()
    {
        $contractTypes = ContractType::all();
        $departments = Department::all();

        return view('contracts.create', compact('contractTypes', 'departments',));
    }

    public function store(Request $request)
    {
        $clientId = $request->client_id;
        $contractNum = Contract::generateContractNumber($clientId);

        $contract = new Contract;
        $contract->contract_num = $contractNum;
        $contract->client_id = $clientId;
        $contract->contract_type_id = $request->contract_type_id;
        $contract->save();
        
        // return redirect()->back()->with('success', '正常に登録し詳細画面に遷移しました');
        return redirect()->route('contracts.edit', ['contract' => $contract->id])->with('success', '正常に登録し詳細画面に遷移しました');
    }

    public function show(Contract $contract)
    {
        //
    }

    public function edit(Contract $contract)
    {
        $contractTypes = ContractType::all();
        $departments = Department::all();
        $contractUpdateTypes = ContractUpdateType::all();
        $contractChangeTypes = ContractChangeType::all();
        $contractPartnerTypes = ContractPartnerType::all();
        $contractSheetStatuses = ContractSheetStatus::all();


        $client = Client::with(['corporation','prefecture'])->where('id',$contract->client_id)->first();

        $firstContractStartAt = $contract->contractDetails()->orderBy('id')->value('contract_start_at');

        $contractDetails = ContractDetail::where('contract_id',$contract->id)->orderBy('contract_start_at','asc')->get();
        $oldestContractDetail = $contract->contractDetails()->oldest()->first();
        $oldestContractPartnerTypeName = $oldestContractDetail ? optional($oldestContractDetail->contractPartnerType)->contract_partner_type_name : null;

        // 最初の契約開始日を取得し、存在しない場合はデフォルトの値を設定
        $oldestContractDetail = ContractDetail::where('contract_id', $contract->id)->orderBy('contract_start_at')->first();

        if ($oldestContractDetail) {
            $startDate = Carbon::parse($oldestContractDetail->contract_start_at);
        } else {
            $startDate = now(); // 現在日時を開始日とする
        }

        // 解約日が存在しない場合は現在日時を使用
        $endDate = $contract->cancelled_at ?? now(); 

        // 契約期間を計算
        $period = $startDate->diff($endDate);

        // 契約期間を文字列に整形（例: "1年2ヶ月3日"）
        $periodString = $period->y . '年' . $period->m . 'ヶ月' . $period->d . '日';

        return view('contracts.edit',compact('contractTypes', 'departments', 'departments','client','contract','contractDetails','contractUpdateTypes','contractChangeTypes','contractPartnerTypes','contractSheetStatuses','firstContractStartAt','oldestContractPartnerTypeName','periodString'));
    }

    public function update(Request $request, Contract $contract)
    {
        $contract = Contract::find($contract->id);

        // $contract->contract_type_id = $request->contract_type_id;
        $contract->cancelled_at = $request->cancelled_at;
        $contract->save();
        
        return redirect()->back()->with('success', '正常に更新されました');
    }

    public function destroy(Contract $contract)
    {
        //
    }
}
