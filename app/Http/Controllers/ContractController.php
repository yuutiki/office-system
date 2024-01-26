<?php

namespace App\Http\Controllers;

use App\Models\Contract;
use App\Models\ContractType;
use Illuminate\Http\Request;

class ContractController extends Controller
{
    public function index()
    {
        $contracts = Contract::all();
        $count = $contracts->count();


        return view('contract.index', compact('contracts','count'));
    }

    public function create()
    {
        $contractTypes = ContractType::all();

        return view('contract.create', compact('contractTypes'));
    }

    public function store(Request $request)
    {
        //
    }

    public function show(Contract $contract)
    {
        //
    }

    public function edit(Contract $contract)
    {
        //
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
