<?php

namespace App\Http\Controllers;

use App\Models\SmtpSetting;
use Illuminate\Http\Request;

class SmtpSettingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $internalSettings = SmtpSetting::where('type', 'internal')->get();
        $externalSettings = SmtpSetting::where('type', 'external')->get();
        
        return view('admin.app-settings.smtp-settings.index', compact('internalSettings', 'externalSettings'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.app-settings.smtp-settings.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'host' => 'required|string|max:255',
            'port' => 'required|integer|min:1|max:65535',
            'username' => 'required|string|max:255',
            'password' => 'nullable|string|max:255|required_if:auth_type,password',
            'encryption' => 'nullable|in:tls,ssl',
            'from_address' => 'required|email',
            'from_name' => 'required|string|max:255',
            'type' => 'required|in:internal,external',
            'auth_type' => 'required|in:password,oauth',
            'oauth_client_id' => 'required_if:auth_type,oauth|nullable|string',
            'oauth_client_secret' => 'required_if:auth_type,oauth|nullable|string',
        ]);

        // OAuthの場合、パスワードは不要
        if ($validated['auth_type'] === 'oauth') {
            $validated['password'] = null;
        }

        SmtpSetting::create($validated);

        return redirect()->route('smtp-settings.index')
            ->with('success', 'SMTP設定を作成しました。');
    }

    /**
     * Display the specified resource.
     */
    public function show(SmtpSetting $smtpSetting)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SmtpSetting $smtpSetting)
    {
        return view('admin.app-settings.smtp-settings.edit', compact('smtpSetting'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SmtpSetting $smtpSetting)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'host' => 'required|string|max:255',
            'port' => 'required|integer|min:1|max:65535',
            'username' => 'required|string|max:255',
            'password' => 'nullable|string|max:255',
            'encryption' => 'nullable|in:tls,ssl',
            'from_address' => 'required|email',
            'from_name' => 'required|string|max:255',
            'type' => 'required|in:internal,external',
            'auth_type' => 'required|in:password,oauth',
            'oauth_client_id' => 'required_if:auth_type,oauth|nullable|string',
            'oauth_client_secret' => 'required_if:auth_type,oauth|nullable|string',
        ]);

        // パスワードが空の場合は更新しない
        if (empty($validated['password'])) {
            unset($validated['password']);
        }

        // OAuthの場合、パスワードは削除
        if ($validated['auth_type'] === 'oauth') {
            $validated['password'] = null;
        }

        $smtpSetting->update($validated);

        return redirect()->route('smtp-settings.index')
            ->with('success', 'SMTP設定を更新しました。');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SmtpSetting $smtpSetting)
    {
        // アクティブな設定は削除できない
        if ($smtpSetting->is_active) {
            return redirect()->route('smtp-settings.index')
                ->with('error', 'アクティブな設定は削除できません。');
        }

        $smtpSetting->delete();

        return redirect()->route('smtp-settings.index')
            ->with('success', 'SMTP設定を削除しました。');
    }

        /**
     * 設定を有効化
     */
    public function setActive(SmtpSetting $smtpSetting)
    {
        // OAuth認証が必要な場合は、トークンがあるか確認
        if ($smtpSetting->auth_type === 'oauth' && !$smtpSetting->hasOAuthTokens()) {
            return redirect()->route('smtp-settings.index')
                ->with('error', 'OAuth認証を完了してから有効化してください。');
        }

        $smtpSetting->setActive();

        return redirect()->route('smtp-settings.index')->with('success', '設定を有効にしました。');
    }

    /**
     * 接続テスト
     */
    public function testConnection(SmtpSetting $smtpSetting)
    {
        try {
            // 一時的に設定を変更してテスト
            if ($smtpSetting->auth_type === 'password') {
                Config::set('mail.mailers.test_smtp', [
                    'transport' => 'smtp',
                    'host' => $smtpSetting->host,
                    'port' => $smtpSetting->port,
                    'encryption' => $smtpSetting->encryption,
                    'username' => $smtpSetting->username,
                    'password' => $smtpSetting->password,
                ]);

                Config::set('mail.from', [
                    'address' => $smtpSetting->from_address,
                    'name' => $smtpSetting->from_name,
                ]);

                // テストメール送信
                Mail::mailer('test_smtp')->raw('SMTP接続テスト', function ($message) use ($smtpSetting) {
                    $message->to($smtpSetting->from_address)
                        ->subject('SMTP接続テスト');
                });
            } else {
                // OAuth認証の場合
                if (!$smtpSetting->hasOAuthTokens()) {
                    throw new Exception('OAuth認証が完了していません。');
                }
                
                // OAuthテスト送信（PHPMailerを使用）
                \App\Services\MailService::sendWithOAuth(
                    $smtpSetting,
                    $smtpSetting->from_address,
                    new \App\Mail\TestMail()
                );
            }

            return redirect()->route('smtp-settings.index')
                ->with('success', '接続テストに成功しました。');
        } catch (Exception $e) {
            return redirect()->route('smtp-settings.index')
                ->with('error', '接続テストに失敗しました: ' . $e->getMessage());
        }
    }
}
