<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SSOController extends Controller
{
    /**
     * SSO URL ジェネレーターの表示
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // ベースURLと暗号化キーの設定
        $baseUrl = config('campus_plan.base_url', 'https://cp.tokyomanagement-u.ac.jp/cpsmart/gakusei/dashboard/main/ja/Account/SSO');
        $encryptionKey = config('campus_plan.encryption_key', 'abcd1234');
        
        return view('sso.generator', [
            'baseUrl' => $baseUrl,
            'encryptionKey' => $encryptionKey
        ]);
    }
}