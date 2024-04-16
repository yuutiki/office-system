<?php

namespace App\Providers;

use App\Observers\GlobalObserver;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Database\Eloquent\Model;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->registerPolicies();


        // // 「システム管理者」だけに適用
        // Gate::define('systemAdmin', function ($user) {
        //     return ($user->role_id == 1);
        // });

        // // 「システム管理者」と「管理者」に適用
        // Gate::define('adminOrAbobe', function ($user) {
        //     return ($user->role_id <= 2);
        // });

        // // 「システム管理者」と「管理者」と「マネージャ」に適用
        // Gate::define('managerOrAbobe', function ($user) {
        //     return ($user->role_id <= 3);
        // });

        // // 「システム管理者」と「管理者」と「マネージャ」「一般」に適用
        // Gate::define('general', function ($user) {
        //     return ($user->role_id <= 4);
        // });
    }
}
