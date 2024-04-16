<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\View\Composers\LinkComposer;
use App\View\Composers\NotificationsComposer;
use App\View\Composers\SystemAdminExcludedUserComposer;
use Illuminate\Support\Facades\View;

class ViewComposerServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        View::composers([
                LinkComposer::class => '*', // 全てのviewに共通データを返す
            ]);

        View::composer('layouts.*', NotificationsComposer::class);

        View::composer('*', SystemAdminExcludedUserComposer::class);
    }
}
