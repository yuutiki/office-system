<?php

namespace App\Http\Controllers;

use App\Models\PasswordPolicy;
use Illuminate\Http\Request;

class PasswordPolicyController extends Controller
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(PasswordPolicy $passwordPolicy)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PasswordPolicy $passwordPolicy)
    {
        $passwordPolicy = PasswordPolicy::firstOrNew(); // ポリシーがなければ新規作成

        return view('admin.password-policy.edit', compact('passwordPolicy'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PasswordPolicy $passwordPolicy)
    {

        // リクエストから送られてきたデータを検証する
        $validatedData = $request->validate([
            'min_length' => 'required|integer|min:1', // 最小桁数（1文字以上）
            'require_uppercase' => 'required|boolean', // 英大文字の必要性
            'require_lowercase' => 'required|boolean', // 英小文字の必要性
            'require_numeric' => 'required|boolean', // 数字の必要性
            'require_symbol' => 'required|boolean', // 記号文字の必要性
            'banned_email_use' => 'required|boolean', // 禁止されたメールの使用
            'banned_password_reuse' => 'required|boolean', // 禁止されたパスワードの再利用
            'max_login_attempt' => 'required|integer|min:1', // 最大ログイン試行回数（1回以上）
            'lockout_time' => 'required|integer|min:1', // ロックアウト時間（1分以上）
            'date_inactive' => 'required|integer|min:1', // ユーザーの無効化日数（1日以上）
            'date_password_expiration' => 'required|integer|min:1', // パスワード有効期限（1日以上）
        ]);
    
        // パスワードポリシーの設定を更新する
        $passwordPolicy->update($validatedData);

        // レスポンスを返す
        return redirect()->route('password-policy.edit', $passwordPolicy)->with(['success' => 'Password policy has been updated successfully']);
        
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PasswordPolicy $passwordPolicy)
    {
        //
    }
}
