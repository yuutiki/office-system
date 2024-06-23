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
    // public function compose(View $view)
    // {
    //     if ($view->getName() === 'link.index') {
    //         // 管理者用のリンク一覧画面の場合、すべてのリンクを事業部別および表示順別に取得
    //         $links = Link::orderBy('department_id')
    //             ->orderBy('display_order')
    //             ->get();
    //     } else {
    //         // 上記以外のユーザ向けリンク一覧（画面上部）など、事業部ごとに絞りたい場合、Userの属性を取得
    //         $userAttributes = auth()->check() ? auth()->user()->department_id : null;
            
    //         // Userの属性と同じ値を持つLinkを取得
    //         $links = Link::where('department_id', $userAttributes)->orderBy('display_order', 'asc')->get();
    //     }
    //     $view->with('links', $links)->with('userAttributes');
    // }

    public function compose(View $view)
    {
        if ($view->getName() === 'link.index') {
            // 管理者用のリンク一覧画面の場合、すべてのリンクを事業部別および表示順別に取得
            $links = Link::orderBy('affiliation2_id')
                ->orderBy('display_order')
                ->get();
        } elseif ($view->getName() === 'errors.503') {
            // エラーページの場合、$linksはnullとして渡す
            $links = null;
        } else {
            // 上記以外のユーザ向けリンク一覧（画面上部）など、事業部ごとに絞りたい場合、Userの属性を取得
            $userAttributes = auth()->check() ? auth()->user()->affiliation2_id : null;
    
            // Userの属性が存在する場合のみクエリを実行
            if ($userAttributes !== null) {
                // Userの属性と同じ値を持つLinkを取得
                $links = Link::where('affiliation2_id', $userAttributes)->orderBy('display_order', 'asc')->get();
            } else {
                // Userの属性が存在しない場合、$linksはnullとして渡す
                $links = null;
            }
        }
        $view->with('links', $links)->with('userAttributes');
    }
}

