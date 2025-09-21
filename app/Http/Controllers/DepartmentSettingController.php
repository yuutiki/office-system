<?php

namespace App\Http\Controllers;

use App\Models\DepartmentSetting;
use Illuminate\Http\Request;

class DepartmentSettingController extends Controller
{
    public function edit()
    {
        $departmentSetting = DepartmentSetting::firstOrCreate([], [
            'max_level'   => 10,
            'code_length' => 6,
        ]);

        return view('admin.app-settings.department-settings.edit', compact('departmentSetting'));
    }

    public function update(Request $request)
    {
        $validatedData = $request->validate([
            'max_level' => 'required|integer|min:1|max:10', // 最大階層数
            'code_length' => 'required|integer|min:1|max:10', // 所属部門コードの最大桁数
        ]);
    
        $departmentSetting = DepartmentSetting::first(); // 常に1件目を更新
        $departmentSetting->update($validatedData);

        return redirect()
            ->route('department-settings.edit', $departmentSetting)
            ->with(['success' => 'department setting has been updated successfully']);
    }
}
