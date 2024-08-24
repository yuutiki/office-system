<?php

namespace App\Providers;

use App\Models\RoleGroup;
use App\Models\User;
use App\Services\PermissionService;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        //
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {

        $this->registerPolicies();

        // システム管理者であればすべてのGateを通過
        Gate::before(function ($user) {
            if ($user->isSystemAdmin()) {
                return true;
            }
        });

        $permissionService = app(PermissionService::class);

        $permissions = config('permissions');

        foreach ($permissions as $resource => $config) {
            foreach ($config['permissions'] as $action => $requiredPermissionId) {
                Gate::define("{$action}_{$resource}", function ($user) use ($permissionService, $config, $requiredPermissionId) {
                    return $permissionService->checkPermission($user, $config['function_menu_code'], $requiredPermissionId);
                });
            }
        }



        // // Usersに関する
        // Gate::define('view_users', function (User $user) {
        //     // ユーザーがFunctionMenu_id=13のPermission_idが2以上（参照権限以上）であるかどうかを確認
        //     $functionMenuPermission = RoleGroup::whereHas('users', function ($query) use ($user) {
        //         $query->where('users.id', $user->id);
        //     })->whereHas('functionMenus', function ($query) {
        //         $query->where('function_menus.id', 13)->where('function_menu_role_group.permission_id', '>=', 2); // 中間テーブルのカラム名を直接指定
        //     })->exists();

        //     return $functionMenuPermission;
        // });

        // Gate::define('storeUpdate_users', function (User $user) {
        //     // ユーザーがFunctionMenu_id=13のPermission_idが3以上（登録更新権限以上）であるかどうかを確認
        //     $functionMenuPermission = RoleGroup::whereHas('users', function ($query) use ($user) {
        //         $query->where('users.id', $user->id);
        //     })->whereHas('functionMenus', function ($query) {
        //         $query->where('function_menus.id', 13)->where('function_menu_role_group.permission_id', '>=', 3); // 中間テーブルのカラム名を直接指定
        //     })->exists();

        //     return $functionMenuPermission;
        // });

        // Gate::define('delete_users', function (User $user) {
        //     // ユーザーがFunctionMenu_id=13のPermission_idが4以上（削除権限以上）であるかどうかを確認
        //     $functionMenuPermission = RoleGroup::whereHas('users', function ($query) use ($user) {
        //         $query->where('users.id', $user->id);
        //     })->whereHas('functionMenus', function ($query) {
        //         $query->where('function_menus.id', 13)->where('function_menu_role_group.permission_id', '>=', 4); // 中間テーブルのカラム名を直接指定
        //     })->exists();

        //     return $functionMenuPermission;
        // });

        // Gate::define('download_users', function (User $user) {
        //     // ユーザーがFunctionMenu_id=13のPermission_idが5以上（書出権限以上）であるかどうかを確認
        //     $functionMenuPermission = RoleGroup::whereHas('users', function ($query) use ($user) {
        //         $query->where('users.id', $user->id);
        //     })->whereHas('functionMenus', function ($query) {
        //         $query->where('function_menus.id', 13)->where('function_menu_role_group.permission_id', '>=', 5); // 中間テーブルのカラム名を直接指定
        //     })->exists();

        //     return $functionMenuPermission;
        // });

        // Gate::define('admin_users', function (User $user) {
        //     // ユーザーがFunctionMenu_id=13のPermission_idが5（全権限）であるかどうかを確認
        //     $functionMenuPermission = RoleGroup::whereHas('users', function ($query) use ($user) {
        //         $query->where('users.id', $user->id);
        //     })->whereHas('functionMenus', function ($query) {
        //         $query->where('function_menus.id', 13)->where('function_menu_role_group.permission_id', '=', 6); // 中間テーブルのカラム名を直接指定
        //     })->exists();

        //     return $functionMenuPermission;
        // });



        // // Corporationsに関する
        // Gate::define('view_corporations', function (User $user) {
        //     // ユーザーがFunctionMenu_id=1のPermission_idが2以上（参照権限以上）であるかどうかを確認
        //     $functionMenuPermission = RoleGroup::whereHas('users', function ($query) use ($user) {
        //         $query->where('users.id', $user->id);
        //     })->whereHas('functionMenus', function ($query) {
        //         $query->where('function_menus.id', 1)->where('function_menu_role_group.permission_id', '>=', 2); // 中間テーブルのカラム名を直接指定
        //     })->exists();

        //     return $functionMenuPermission;
        // });

        // Gate::define('storeUpdate_corporations', function (User $user) {
        //     // ユーザーがFunctionMenu_id=1のPermission_idが3以上（登録更新権限以上）であるかどうかを確認
        //     $functionMenuPermission = RoleGroup::whereHas('users', function ($query) use ($user) {
        //         $query->where('users.id', $user->id);
        //     })->whereHas('functionMenus', function ($query) {
        //         $query->where('function_menus.id', 1)->where('function_menu_role_group.permission_id', '>=', 3); // 中間テーブルのカラム名を直接指定
        //     })->exists();

        //     return $functionMenuPermission;
        // });

        // Gate::define('delete_corporations', function (User $user) {
        //     // ユーザーがFunctionMenu_id=1のPermission_idが4以上（削除権限以上）であるかどうかを確認
        //     $functionMenuPermission = RoleGroup::whereHas('users', function ($query) use ($user) {
        //         $query->where('users.id', $user->id);
        //     })->whereHas('functionMenus', function ($query) {
        //         $query->where('function_menus.id', 1)->where('function_menu_role_group.permission_id', '>=', 4); // 中間テーブルのカラム名を直接指定
        //     })->exists();

        //     return $functionMenuPermission;
        // });

        // Gate::define('download_corporations', function (User $user) {
        //     // ユーザーがFunctionMenu_id=1のPermission_idが5以上（書出権限以上）であるかどうかを確認
        //     $functionMenuPermission = RoleGroup::whereHas('users', function ($query) use ($user) {
        //         $query->where('users.id', $user->id);
        //     })->whereHas('functionMenus', function ($query) {
        //         $query->where('function_menus.id', 1)->where('function_menu_role_group.permission_id', '>=', 5); // 中間テーブルのカラム名を直接指定
        //     })->exists();

        //     return $functionMenuPermission;
        // });

        // Gate::define('admin_corporations', function (User $user) {
        //     // ユーザーがFunctionMenu_id=1のPermission_idが5（全権限）であるかどうかを確認
        //     $functionMenuPermission = RoleGroup::whereHas('users', function ($query) use ($user) {
        //         $query->where('users.id', $user->id);
        //     })->whereHas('functionMenus', function ($query) {
        //         $query->where('function_menus.id', 1)->where('function_menu_role_group.permission_id', '=', 6); // 中間テーブルのカラム名を直接指定
        //     })->exists();

        //     return $functionMenuPermission;
        // });

        // // Clientsに関する
        // Gate::define('view_clients', function (User $user) {
        //     // ユーザーがFunctionMenu_id=1のPermission_idが2以上（参照権限以上）であるかどうかを確認
        //     $functionMenuPermission = RoleGroup::whereHas('users', function ($query) use ($user) {
        //         $query->where('users.id', $user->id);
        //     })->whereHas('functionMenus', function ($query) {
        //         $query->where('function_menus.id', 1)->where('function_menu_role_group.permission_id', '>=', 2); // 中間テーブルのカラム名を直接指定
        //     })->exists();

        //     return $functionMenuPermission;
        // });

        // Gate::define('storeUpdate_clients', function (User $user) {
        //     // ユーザーがFunctionMenu_id=1のPermission_idが3以上（登録更新権限以上）であるかどうかを確認
        //     $functionMenuPermission = RoleGroup::whereHas('users', function ($query) use ($user) {
        //         $query->where('users.id', $user->id);
        //     })->whereHas('functionMenus', function ($query) {
        //         $query->where('function_menus.id', 1)->where('function_menu_role_group.permission_id', '>=', 3); // 中間テーブルのカラム名を直接指定
        //     })->exists();

        //     return $functionMenuPermission;
        // });

        // Gate::define('delete_clients', function (User $user) {
        //     // ユーザーがFunctionMenu_id=1のPermission_idが4以上（削除権限以上）であるかどうかを確認
        //     $functionMenuPermission = RoleGroup::whereHas('users', function ($query) use ($user) {
        //         $query->where('users.id', $user->id);
        //     })->whereHas('functionMenus', function ($query) {
        //         $query->where('function_menus.id', 1)->where('function_menu_role_group.permission_id', '>=', 4); // 中間テーブルのカラム名を直接指定
        //     })->exists();

        //     return $functionMenuPermission;
        // });

        // Gate::define('download_clients', function (User $user) {
        //     // ユーザーがFunctionMenu_id=1のPermission_idが5以上（書出権限以上）であるかどうかを確認
        //     $functionMenuPermission = RoleGroup::whereHas('users', function ($query) use ($user) {
        //         $query->where('users.id', $user->id);
        //     })->whereHas('functionMenus', function ($query) {
        //         $query->where('function_menus.id', 1)->where('function_menu_role_group.permission_id', '>=', 5); // 中間テーブルのカラム名を直接指定
        //     })->exists();

        //     return $functionMenuPermission;
        // });

        // Gate::define('admin_clients', function (User $user) {
        //     // ユーザーがFunctionMenu_id=1のPermission_idが5（全権限）であるかどうかを確認
        //     $functionMenuPermission = RoleGroup::whereHas('users', function ($query) use ($user) {
        //         $query->where('users.id', $user->id);
        //     })->whereHas('functionMenus', function ($query) {
        //         $query->where('function_menus.id', 1)->where('function_menu_role_group.permission_id', '=', 6); // 中間テーブルのカラム名を直接指定
        //     })->exists();

        //     return $functionMenuPermission;
        // });
    }
}
