<?php

namespace App\Http\Controllers;

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
    public function create()
    {
        $contractTypes = ContractType::all();
        $contractUpdateTypes = ContractUpdateType::all();
        $contractChangeTypes = ContractChangeType::all();
        $contractPartnerTypes = ContractPartnerType::all();
        $contractSheetStatuses = ContractSheetStatus::all();

        return view('contract-details.create',compact('contractTypes','contractUpdateTypes','contractChangeTypes','contractPartnerTypes','contractSheetStatuses',));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
    public function edit(ContractDetail $contractDetail)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ContractDetail $contractDetail)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ContractDetail $contractDetail)
    {
        //
    }
}
