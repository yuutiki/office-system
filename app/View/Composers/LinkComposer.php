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
        $links = Link::orderBy('display_order')->get();
        $view->with('links', $links);
    }
}

