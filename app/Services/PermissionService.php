<?php

namespace App\Services;

use App\Models\User;
use App\Models\FunctionMenu;

class PermissionService
{
    protected array $cache = [];
    protected array $functionMenusCache = [];

    public function __construct()
    {
        // アプリ起動時に全 function_menus をキャッシュ
        $this->functionMenusCache = FunctionMenu::all()->keyBy('function_menu_code')->toArray();
    }

    public function checkPermission(User $user, string $functionMenuCode, int $requiredPermissionId): bool
    {
        $cacheKey = $user->id . '_' . $functionMenuCode . '_' . $requiredPermissionId;

        if (isset($this->cache[$cacheKey])) {
            return $this->cache[$cacheKey];
        }

        // eagerロードされていなければロード
        if (!$user->relationLoaded('roleGroups') || $user->roleGroups->isEmpty() || $user->roleGroups->first()->relationLoaded('functionMenus') === false) {
            $user->load('roleGroups.functionMenus');
        }

        $functionMenu = $this->functionMenusCache[$functionMenuCode] ?? null;
        if (!$functionMenu) {
            return $this->cache[$cacheKey] = false;
        }

        $result = $user->roleGroups->contains(function ($roleGroup) use ($functionMenu, $requiredPermissionId) {
            return $roleGroup->functionMenus->contains(function ($menu) use ($functionMenu, $requiredPermissionId) {
                return $menu['id'] === $functionMenu['id'] && $menu['pivot']['permission_id'] >= $requiredPermissionId;
            });
        });

        return $this->cache[$cacheKey] = $result;
    }
}
