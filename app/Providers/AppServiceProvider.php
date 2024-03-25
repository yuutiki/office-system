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

        // 「システム管理者」と「管理者」と「マネージャ」に適用
        Gate::define('managerOrAbobe', function ($user) {
            return ($user->role_id <= 3);
        });

        // 「システム管理者」と「管理者」と「マネージャ」「一般」に適用
        Gate::define('general', function ($user) {
            return ($user->role_id <= 4);
        });

        // Gate::define('view_user_management', function (User $user) {
        //     // ユーザーが関連するロールを取得
        //     $roles = $user->roles;
        
        //     // ユーザーが管理者ロールを持っているかどうかをチェック
        //     if ($roles->contains('name', 'admin')) {
        //         return true; // 管理者は常に表示を許可する
        //     }
        
        //     // ユーザーがFunctionMenu_id=13のPermission_idが2以下であるかどうかを確認
        //     $functionMenuPermission = $user->functionMenus()->where('id', 13)->first()->pivot->permission_id;
        //     if ($functionMenuPermission <= 2) {
        //         return true; // ユーザーが必要な権限を持っている場合は表示を許可する
        //     }
        
        //     return false; // ユーザーが必要な権限を持っていない場合は表示を許可しない
        // });


        // Model::creating(function ($model) {
        //     $model->created_by = auth()->user()->id;
        // });

        // Model::updating(function ($model) {
        //     $model->updated_by = auth()->user()->id;
        // });

        // ClientCorporation::observe(GlobalObserver::class);
    }
}
