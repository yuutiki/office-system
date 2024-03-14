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
        $contractDetails = ContractDetail::where('contract_id',$contract->id)->orderBy('contract_start_at','asc')->get();


        return view('contracts.edit',compact('contractTypes', 'departments', 'departments','client','contract','contractDetails','contractUpdateTypes','contractChangeTypes','contractPartnerTypes','contractSheetStatuses',));
    }

    public function update(Request $request, Contract $contract)
    {
        //
    }

    public function destroy(Contract $contract)
    {
        //
    }
}
