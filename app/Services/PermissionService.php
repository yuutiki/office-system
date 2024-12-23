<?php

namespace App\Services;

use App\Models\User;
use App\Models\RoleGroup;
use App\Models\FunctionMenu;

class PermissionService
{
    public function checkPermission(User $user, string $functionMenuCode, int $requiredPermissionId): bool
    {
       $functionMenu = FunctionMenu::where('function_menu_code', $functionMenuCode)->first();
       
       if (!$functionMenu) {
           return false;
       }
    
       $result = RoleGroup::whereHas('users', function ($query) use ($user) {
           $query->where('users.id', $user->id);
       })->whereHas('functionMenus', function ($query) use ($functionMenu, $requiredPermissionId) {
           $query->where('function_menus.id', $functionMenu->id)
                 ->where('function_menu_role_group.permission_id', '>=', $requiredPermissionId);
       })->exists();
        
       return $result;
    }
}