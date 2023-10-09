<?php

namespace App\Providers;

// use Illuminate\Support\Facades\View;
// use App\View\Composers\LinkComposer;
// use Illuminate\Support\ServiceProvider;
// use App\Observers\GlobalObserver;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

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
        // ClientCorporation::observe(GlobalObserver::class);

        $this->registerPolicies();

        // 「システム管理者」だけに適用
        Gate::define('systemAdmin', function ($user) {
            return ($user->role_id == 1);
        });

        // 「システム管理者」と「管理者」に適用
        Gate::define('adminOrAbobe', function ($user) {
            return ($user->role_id <= 2);
        });

        // 「最強」と「普通」と「最弱」全てに適用
        Gate::define('manager', function ($user) {
            return ($user->role_id <= 3);
        });

        // 「最強」と「普通」と「最弱」全てに適用
        Gate::define('general', function ($user) {
            return ($user->role_id <= 4);
        });
    }
}
