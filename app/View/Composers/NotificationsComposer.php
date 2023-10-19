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
            $links = Link::orderBy('department_id')
                ->orderBy('display_order')
                ->get();
        } else {
             
            // 未読通知を取得するコードをここに記述します
            $unreadNotifications = auth()->check() ? auth()->user()->unreadNotifications : null;
        }
        $view->with('unreadNotifications', $unreadNotifications);
    }
}

