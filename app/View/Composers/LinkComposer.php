<?php

namespace App\View\Composers;

use App\Models\Link; //add
use Illuminate\View\View;

/**
 * Class UserComposer
 * @package App\Http\ViewComposers
 */
class LinkComposer
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
            // リンク管理画面など、事業部ごとに絞りたい場合、Userの属性を取得
            $userAttributes = auth()->check() ? auth()->user()->department_id : null;
            
            // Userの属性と同じ値を持つLinkを取得
            $links = Link::where('department_id', $userAttributes)->orderBy('display_order')->get();
        }
        $view->with('links', $links);
    }
}

