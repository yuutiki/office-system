<?php

namespace App\Http\Controllers;

use App\Models\AppMaster;
use Illuminate\Http\Request;

class AppMasterController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $perPage = config('constants.perPage');

        // $masterTypes = MasterType::all();

        // 検索用の値を取得
        $masterCode = $request->master_code;
        $masterName = $request->master_name;

        $mastersQuery = AppMaster::sortable();

        if(!empty($masterCode)) {
            $mastersQuery =AppMaster::where('master_code', $masterCode);
        }

        if(!empty($masterName)) {
            $mastersQuery =AppMaster::where('master_name', 'like', '%' . $masterName . '%');
        }

        $masters = $mastersQuery->paginate($perPage);
        $count = $masters->total();

        return view('masters.index', compact('masters', 'count', 'masterCode', 'masterName'));
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(AppMaster $appMaster)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(AppMaster $appMaster)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, AppMaster $appMaster)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(AppMaster $appMaster)
    {
        //
    }
}
