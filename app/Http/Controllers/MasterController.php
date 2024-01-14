<?php

namespace App\Http\Controllers;

use App\Models\Prefecture;
use App\Models\ProductType;
use Illuminate\Http\Request;

class MasterController extends Controller
{
    public function index()
    {
        // $prefectures = Prefecture::all();
        // $productTypes = ProductType::all();

        $masters = [
            ['name' => '顧客種別', 'route' => 'client-type.index'],
            ['name' => '設置種別', 'route' => 'installation-type.index'],
            ['name' => '取引状態', 'route' => 'trade-status.index'],
            ['name' => '商流種別', 'route' => 'distribution-type.index'],
            ['name' => '所属-階層1', 'route' => 'company.index'],
            ['name' => '所属-階層2', 'route' => 'department.index'],
            ['name' => '所属-階層3', 'route' => 'affiliation3.index'],
            ['name' => '製品種別', 'route' => 'product-type.index'],
            ['name' => '製品内訳種別', 'route' => 'product-split-type.index'],
            ['name' => '製品カテゴリ', 'route' => 'product-category.index'],
            ['name' => '製品メーカ', 'route' => 'product-maker.index'],
            ['name' => '製品シリーズ', 'route' => 'product-series.index'],
            ['name' => '製品バージョン', 'route' => 'product-version.index'],
            ['name' => 'プロジェクト種別', 'route' => 'project-type.index'],
            ['name' => '営業段階', 'route' => 'sales-stage.index'],
            ['name' => 'サポート時間', 'route' => 'support-time.index'],
            ['name' => 'サポート種別', 'route' => 'support-type.index'],
            ['name' => '営業報告種別', 'route' => 'report-type.index'],
            ['name' => '対応種別', 'route' => 'contact-type.index'],
            ['name' => '計上種別', 'route' => 'accounting-type.index'],
            ['name' => '計上期', 'route' => 'accounting-period.index'],
            ['name' => '都道府県', 'route' => 'prefecture.index'],
            // 他のマスタ情報も同様に追加
        ];

        return view('masters.index', compact('masters'));
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show(string $id)
    {
        //
    }

    public function edit(string $id)
    {
        //
    }

    public function update(Request $request, string $id)
    {
        //
    }

    public function destroy(string $id)
    {
        //
    }
}
