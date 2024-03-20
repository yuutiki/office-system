<?php

namespace App\Http\Controllers;

use App\Models\AppMaster;
use Illuminate\Http\Request;

class AppMasterController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // $prefectures = Prefecture::all();
        // $productTypes = ProductType::all();

        $masters = AppMaster::all();
        // $masters = [
        //     ['name' => '顧客種別', 'route' => 'client-type.index'],
        //     ['name' => '設置種別', 'route' => 'installation-type.index'],
        //     ['name' => '取引状態', 'route' => 'trade-status.index'],
        //     ['name' => '商流種別', 'route' => 'distribution-type.index'],
        //     ['name' => '所属-階層1', 'route' => 'company.index'],
        //     ['name' => '所属-階層2', 'route' => 'department.index'],
        //     ['name' => '所属-階層3', 'route' => 'affiliation3.index'],
        //     ['name' => '製品種別', 'route' => 'product-type.index'],
        //     ['name' => '製品内訳種別', 'route' => 'product-split-type.index'],
        //     ['name' => '製品カテゴリ', 'route' => 'product-category.index'],
        //     ['name' => '製品メーカ', 'route' => 'product-maker.index'],
        //     ['name' => '製品シリーズ', 'route' => 'product-series.index'],
        //     ['name' => '製品バージョン', 'route' => 'product-version.index'],
        //     ['name' => 'プロジェクト種別', 'route' => 'project-type.index'],
        //     ['name' => '営業段階', 'route' => 'sales-stage.index'],
        //     ['name' => 'サポート時間', 'route' => 'support-time.index'],
        //     ['name' => 'サポート種別', 'route' => 'support-type.index'],
        //     ['name' => '営業報告種別', 'route' => 'report-type.index'],
        //     ['name' => '対応種別', 'route' => 'contact-type.index'],
        //     ['name' => '計上種別', 'route' => 'accounting-type.index'],
        //     ['name' => '計上期', 'route' => 'accounting-period.index'],
        //     ['name' => '都道府県', 'route' => 'prefecture.index'],
        //     ['name' => '業者種別', 'route' => 'prefecture.index'],
        // ];

        return view('masters.index', compact('masters'));
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
