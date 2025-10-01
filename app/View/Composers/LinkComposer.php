<?php

namespace App\View\Composers;

use App\Models\Link;
use App\Models\User;
use Illuminate\View\View;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Auth;

class LinkComposer
{
    public function compose(View $view)
    {
        $viewName = $view->getName();

        // エラーページの場合、$linksはnullとして渡す
        if ($viewName === 'errors.503') {
            $view->with('links', null);
            return;
        }

        $links = $this->getUserLinks();
        $view->with('links', $links);
    }

    private function getUserLinks()
    {
        if (!Auth::check()) {
            return collect();
        }

        $user = Auth::user();
        $userDepartment = $user->department; // User モデルに department リレーションがある前提

        if (!$userDepartment) {
            return collect();
        }

        // ユーザー自身の所属部門 + その親（祖先）部門
        $deptIds = [$userDepartment->id];
        $deptIds = array_merge($deptIds, $userDepartment->getAncestorIds());

        return Cache::remember("user_links_{$user->id}", now()->addHours(1), function () use ($deptIds) {
            return Link::whereIn('department_id', $deptIds)
                    ->orderBy('display_order')
                    ->get();
        });
    }


    public static function clearCache($userId = null)
    {
        if ($userId) {
            Cache::forget("user_links_{$userId}");
        } else {
            // すべてのユーザーのキャッシュをクリア
            $users = User::pluck('id')->toArray();
            foreach ($users as $id) {
                Cache::forget("user_links_{$id}");
            }
        }
    }

    // 新しいメソッド：特定のaffiliation2_idに関連するキャッシュをクリア
    public static function clearCacheForAffiliation($affiliation2Id)
    {
        $users = User::where('affiliation2_id', $affiliation2Id)->pluck('id')->toArray();
        foreach ($users as $userId) {
            Cache::forget("user_links_{$userId}");
        }
    }
}