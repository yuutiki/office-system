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


    protected $appends = ['path']; // JSONに含める
    
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
        return $this->hasMany(Department::class, 'parent_id')->with('children');
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
     * 指定部門の子孫IDをすべて取得（子孫部門のIDを再帰的に取得）
     */
    /**
     * 再帰的に子孫部門IDを取得
     */
    public function getDescendantIds(): array
    {
        $ids = [];

        foreach ($this->children as $child) {
            $ids[] = $child->id;
            // 子の子も再帰的に取得
            $ids = array_merge($ids, $child->getDescendantIds());
        }

        return $ids;
    }

    /**
     * 再帰的に親（祖先）部門IDを取得
     */
    public function getAncestorIds(): array
    {
        $ids = [];

        if ($this->parent) {
            $ids[] = $this->parent->id;
            $ids = array_merge($ids, $this->parent->getAncestorIds());
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

public static function getHierarchy($parentId = null, $level = 0)
{
    $departments = self::where('parent_id', $parentId)
        ->with('children')   // ← eager load
        ->orderBy('code')
        ->get();

    $result = collect();

    foreach ($departments as $dept) {
        $dept->level = $level; // ← ここで level をセット
        $result->push($dept);

        // 子供を再帰的に追加
        $children = self::getHierarchy($dept->id, $level + 1);
        $result = $result->merge($children);
    }

    return $result;
}

public static function getTree($parentId = null)
{
    return self::where('parent_id', $parentId)
        ->orderBy('code')
        ->with(['children' => function ($query) {
            $query->orderBy('code');
        }])
        ->get();
}



    /**
     * 自分から親をたどってルートまで返す（ユーザー表示用）
     * ex. [本社, 営業部, 第一営業課]
     */
    public function getHierarchyPath(): array
    {
        $hierarchy = [];
        $current = $this;

        while ($current) {
            $hierarchy[] = $current;
            $current = $current->parent;
        }

        return array_reverse($hierarchy);
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


    /**
     * 階層構造でソートされた部署リストを取得
     *
     * @param \Illuminate\Database\Eloquent\Collection|null $departments
     * @param int|null $parentId
     * @param int $level
     * @return array
     */
    public static function buildTree($departments = null, $parentId = null, $level = 0)
    {
        // $departmentsが渡されなかった場合は全部署を取得
        if ($departments === null) {
            $departments = self::all();
        }

        $result = [];
        foreach ($departments->where('parent_id', $parentId)->sortBy('id') as $department) {
            $department->level = $level;

            // path（親からの経路文字列）を作っておくと便利
            $department->path = str_repeat('— ', $level) . $department->name;

            $result[] = $department;
            $result = array_merge($result, self::buildTree($departments, $department->id, $level + 1));
        }
        return $result;
    }


    /**
     * 一番上の階層（ルート部門）を取得
     */
    public function getRootDepartment(): self
    {
        $department = $this;
        while ($department->parent) {
            $department = $department->parent;
        }
        return $department;
    }

    /**
     * 一番上の階層の名称を直接取得するアクセサ
     */
    public function getRootNameAttribute(): string
    {
        return $this->getRootDepartment()->name;
    }


    /**
     * 階層構造でソートされた全部署を取得（convenience method）
     *
     * @return array
     */
    public static function getTreeStructure()
    {
        return self::buildTree();
    }

    public function clients()
    {
        return $this->hasMany(Client::class);
    }
}
