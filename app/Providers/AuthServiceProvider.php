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
    }
}
