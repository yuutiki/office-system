<?php

namespace App\Http\Controllers;

use App\Models\ModelHistory;
use Illuminate\Http\Request;

class ModelHistoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
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
            ->latest()
            ->paginate($perPage);

        $count = $histories->total();
        $models = ModelHistory::distinct('model')->pluck('model');
        $operationTypes = ModelHistory::distinct('operation_type')->pluck('operation_type');

        return view('admin.logs.index', compact('histories', 'models', 'operationTypes', 'count'));
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
    public function show(ModelHistory $modelHistory)
    {
        return view('admin.logs.show', compact('modelHistory'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ModelHistory $modelHistory)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ModelHistory $modelHistory)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ModelHistory $modelHistory)
    {
        //
    }
}
