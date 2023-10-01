<?php

namespace App\View\Composers;

use App\Models\Link;
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
    public function compose(View $view)
    {
        $links = Link::orderBy('display_order')->get();
        $view->with('links', $links);
    }
}

