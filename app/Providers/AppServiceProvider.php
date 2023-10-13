<?php

namespace App\Providers;

// use Illuminate\Support\Facades\View;
// use App\View\Composers\LinkComposer;
// use Illuminate\Support\ServiceProvider;
use App\Observers\GlobalObserver;

use App\Models\ClientCorporation;
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


        Model::creating(function ($model) {
            $model->created_by = auth()->user()->id;
        });

        Model::updating(function ($model) {
            $model->updated_by = auth()->user()->id;
        });

        // ClientCorporation::observe(GlobalObserver::class);
    }
}
