<?php

namespace App\Listeners;

use App\Models\User;
use Illuminate\Auth\Events\Authenticated;
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
    public function handle(Authenticated $event): void
    {
        // ログインしたら最終ログイン日時をDBに登録（履歴を残さない）
        // モデルのクラスを経由してwithoutLoggingを呼び出す
        User::withoutLogging(function () use ($event) {
            $event->user->last_login_at = now();
            $event->user->save();
        });
    }
}
