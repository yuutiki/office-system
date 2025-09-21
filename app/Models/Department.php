<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Department extends Model
{
    protected $fillable = ['code', 'name', 'parent_id', 'level', 'is_active'];

    // 常に親部門を取得
    protected $with = ['parent'];
    
    /**
     * 親部門
     */
    public function parent(): BelongsTo
    {
        return $this->belongsTo(Department::class, 'parent_id');
    }

    /**
     * 子部門
     */
    public function children(): HasMany
    {
        return $this->hasMany(Department::class, 'parent_id');
    }

    /**
     * 所属パス（上位階層をすべて含む）
     */
    public function getPathAttribute(): string
    {
        $ancestors = collect([]);
        $current = $this;

        while ($current) {
            $ancestors->prepend($current->name);
            $current = $current->parent;
        }

        return $ancestors->join(' > ');
    }


    /**
     * 子孫部門のIDを再帰的に取得
     */
    public function getDescendantIds(): array
    {
        $ids = [$this->id];

        foreach ($this->children as $child) {
            $ids = array_merge($ids, $child->getDescendantIds());
        }

        return $ids;
    }



    public function getAncestorNames(): array
    {
        $ancestors = [];
        $current = $this;
        while ($current) {
            array_unshift($ancestors, $current->name);
            $current = $current->parent;
        }
        return $ancestors;
    }

    /**
     * 指定した階層の部門名を返す
     * 1 = 最上位, 2 = 2階層目, ...
     */
    public function getLevelName(int $level): ?string
    {
        $names = $this->getAncestorNames();
        return $names[$level - 1] ?? null;
    }

// Bladeで任意の階層を表示させる
// {{-- 2階層目 --}}
// {{ $client->department?->getLevelName(2) ?? '-' }}

// {{-- 3階層目 --}}
// {{ $client->department?->getLevelName(3) ?? '-' }}

// {{-- 全階層（パス） --}}
// {{ implode(' > ', $client->department?->getAncestorNames() ?? []) }}

// app/Models/Department.php
// public function childrenRecursive()
// {
//     return $this->children()->with('childrenRecursive');
// }

public static function getHierarchy($parentId = null)
{
    $departments = self::where('parent_id', $parentId)
        ->orderBy('code')
        ->get();

    $result = collect();

    foreach ($departments as $dept) {
        $result->push($dept);
        $children = self::getHierarchy($dept->id);
        $result = $result->merge($children);
    }

    return $result;
}

    /**
     * 循環参照が発生するかチェック
     *
     * @param int $newParentId
     * @return bool
     */
    public function wouldCreateCircularReference(int $newParentId): bool
    {
        // 新しい親が自分自身ならアウト
        if ($this->id === $newParentId) {
            return true;
        }

        // 新しい親を辿っていき、自分のIDが出てきたら循環
        $parent = Department::find($newParentId);
        while ($parent) {
            if ($parent->id === $this->id) {
                return true;
            }
            $parent = $parent->parent;
        }

        return false;
    }

    /**
     * 子孫の階層レベルをチェック（最大階層数を超えるか）
     */
    public function wouldExceedMaxLevel(int $newLevel, int $maxLevel): bool
    {
        if ($newLevel > $maxLevel) {
            return true;
        }

        foreach ($this->children as $child) {
            // 子の新しいレベルを計算
            $childNewLevel = $newLevel + 1;
            if ($child->wouldExceedMaxLevel($childNewLevel, $maxLevel)) {
                return true;
            }
        }

        return false;
    }

    /**
     * 実際に階層を更新
     */
    public function updateHierarchyLevels()
    {
        foreach ($this->children as $child) {
            $child->level = $this->level + 1;
            $child->save();

            $child->updateHierarchyLevels();
        }
    }

    public function clients()
    {
        return $this->hasMany(Client::class);
    }
}
