<?php

namespace App\Listeners;

use App\Models\User;
use Illuminate\Auth\Events\Login;
// use Illuminate\Auth\Events\Authenticated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class LogAuthenticated
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */

    // 以下Authenticatedイベントは認証ユーザーがリクエストを送信するたびに発火してしまう
    // public function handle(Authenticated $event): void
    // {
    //     // ログインしたら最終ログイン日時をDBに登録（履歴を残さない）
    //     // モデルのクラスを経由してwithoutLoggingを呼び出す
    //     User::withoutLogging(function () use ($event) {
    //         $event->user->last_login_at = now();
    //         $event->user->save();
    //     });
    // }

    public function handle(Login $event): void  // Loginイベントに変更
    {
        // ログイン時のみ最終ログイン日時をDBに登録
        User::withoutLogging(function () use ($event) {
            $event->user->last_login_at = now();
            $event->user->save();
        });
    }
}
