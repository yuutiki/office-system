<?php

namespace App\Http\Controllers;

use App\Models\ModelHistory;
use Illuminate\Http\Request;

class ModelHistoryController extends Controller
{
    public function index(Request $request)
    {
        $perPage =config('constants.perPage');

        $histories = ModelHistory::with('user')
            ->when($request->filled('model'), function ($query) use ($request) {
                return $query->where('model', $request->model);
            })
            ->when($request->filled('operation_type'), function ($query) use ($request) {
                return $query->where('operation_type', $request->operation_type);
            })
            ->when($request->filled('search_text'), function ($query) use ($request) {
                return $query->where(function($q) use ($request) {
                    // ユーザーIDの検索
                    $q->whereHas('user', function($userQuery) use ($request) {
                        $userQuery->where('user_num', 'LIKE', "%{$request->search_text}%");
                    })
                    // IPアドレスの検索
                    ->orWhere('ip_address', 'LIKE', "%{$request->search_text}%");
                });
            })
            // 期間検索の追加
            ->when($request->filled('date_from'), function ($query) use ($request) {
                return $query->where('created_at', '>=', $request->date_from);
            })
            ->when($request->filled('date_to'), function ($query) use ($request) {
                return $query->where('created_at', '<=', $request->date_to);
            })
            ->latest()
            ->paginate($perPage);

        // 日付範囲の初期値設定（例：過去1年分）
        $now = now();
        $minDate = $now->copy()->subYear()->startOfDay()->format('Y-m-d\TH:i');
        $maxDate = $now->format('Y-m-d\TH:i');

        $models = ModelHistory::distinct('model')->pluck('model');
        $operationTypes = ModelHistory::distinct('operation_type')->pluck('operation_type');
        $searchText = $request->search_text;

        return view('admin.logs.index', compact('histories', 'models', 'operationTypes', 'searchText', 'minDate', 'maxDate'));
    }

    // public function create()
    // {
    //     //
    // }

    // public function store(Request $request)
    // {
    //     //
    // }

    public function show(ModelHistory $modelHistory)
    {
        return view('admin.logs.show', compact('modelHistory'));
    }

    // public function edit(ModelHistory $modelHistory)
    // {
    //     //
    // }

    // public function update(Request $request, ModelHistory $modelHistory)
    // {
    //     //
    // }

    // public function destroy(ModelHistory $modelHistory)
    // {
    //     //
    // }
}
