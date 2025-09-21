<?php

namespace App\View\Composers;

use App\Models\Link; //add
use Illuminate\View\View;

/**
 * Class UserComposer
 * @package App\Http\ViewComposers
 */
class NotificationsComposer
{    
   
    /**
     * Bind data to the view.
     * @param View $view
     * @return void
     */

     //すべて（もしくは一部）のViewで利用するデータを取得し$viewにわたす。
     //で、どのViewにわたすかは　App/Providers/ViewComposerServiceProvider.php　に記載している。
    public function compose(View $view)
    {
        if ($view->getName() === 'link.index') {
            // リンク一覧画面の場合、すべてのリンクを事業部別および表示順別に取得
            $unreadNotifications = collect(); // 空のコレクションで代用
        } else {
            // 通知を取得（未ログイン時は空）
            $unreadNotifications = auth()->check()
                ? auth()->user()->unreadNotifications
                : collect();
        }
        $view->with('unreadNotifications', $unreadNotifications);
    }
}

