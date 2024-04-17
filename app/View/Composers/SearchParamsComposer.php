<?php

namespace App\View\Composers;

use Illuminate\Support\Facades\Session;
use Illuminate\View\View;

/**
 * Class UserComposer
 * @package App\Http\ViewComposers
 */
class SearchParamsComposer
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
        $searchParams = Session::get('search_params', []);
        $view->with('searchParams', $searchParams);
    }
}