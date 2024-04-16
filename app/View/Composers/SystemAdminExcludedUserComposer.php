<?php

namespace App\View\Composers;

use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class SystemAdminExcludedUserComposer
{
    public function compose(View $view)
    {
        $loggedInUserId = Auth::id();

        // ログインユーザがid1以外の場合はid1を除外
        if ($loggedInUserId !== 1) {
            $users = User::where('id', '!=', 1)->get();
        } else {
            // ログインユーザがid1の場合はid1を含める
            $users = User::all();
        }

        $view->with('usersFromComposer', $users);
    }
}
