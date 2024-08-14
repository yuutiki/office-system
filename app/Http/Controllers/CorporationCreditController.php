<?php

namespace App\Http\Controllers;

use App\Models\CorporationCredit;
use Illuminate\Http\Request;

class CorporationCreditController extends Controller
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
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $creditLimit = $request->input('credit_limit');
        $creditLimitStr = str_replace(',', '', $creditLimit);

        $corporationCredit = new CorporationCredit;

        $corporationCredit->credit_limit = $creditLimitStr;
        $corporationCredit->credit_rate = $request->input('credit_rate');
        $corporationCredit->credit_rater = $request->input('credit_rater');
        $corporationCredit->credit_reason = $request->input('credit_reason');
        $corporationCredit->corporation_id = $request->input('corporation_id');
        $corporationCredit->save();

        return redirect()->back()->with('success', '正常に登録しました');
    }

    /**
     * Display the specified resource.
     */
    public function show(CorporationCredit $corporationCredit)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(CorporationCredit $corporationCredit)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, CorporationCredit $corporationCredit)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CorporationCredit $corporationCredit)
    {
        $corporationCredit = CorporationCredit::find($corporationCredit->ulid);
        $corporationCredit->delete();

        return redirect()->back()->with('success', '正常に削除しました');
    }
}
