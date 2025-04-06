<?php

namespace App\Http\Controllers;

use App\Models\UserColumnSetting;
use Illuminate\Http\Request;

class UserSettingsController extends Controller
{
    public function index()
    {
        //
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show(UserColumnSetting $userColumnSetting)
    {
        //
    }

    public function edit(UserColumnSetting $userColumnSetting)
    {
        //
    }

    public function update(Request $request, UserColumnSetting $userColumnSetting)
    {
        //
    }

    public function destroy(UserColumnSetting $userColumnSetting)
    {
        //
    }

    public function saveColumnSettings(Request $request)
    {
        $validated = $request->validate([
            'page_identifier' => 'required|string',
            'visible_columns' => 'required|array',
            'visible_columns.*' => 'string'
        ]);
        
        UserColumnSetting::updateOrCreate(
            [
                'user_id' => auth()->id(),
                'page_identifier' => $validated['page_identifier']
            ],
            [
                'visible_columns' => $validated['visible_columns']
            ]
        );
        
        return back()->with('success', '表示設定を保存しました');
    }
}
