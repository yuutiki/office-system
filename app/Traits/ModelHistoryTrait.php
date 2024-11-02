<?php

namespace App\Traits;

use App\Models\ModelHistory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

trait ModelHistoryTrait
{
    protected static $disableLogging = false;
    protected static $loggingStack = [];

    protected static function bootModelHistoryTrait(): void
    {
        $events = ['created', 'updated', 'deleted']; // 'retrieved' を削除

        foreach ($events as $event) {
            static::$event(function (Model $model) use ($event) {
                if (!static::$disableLogging && !static::isLoggingDisabled()) {
                    $model->recordHistory($event);
                }
            });
        }
    }

    public static function disableLogging(): void
    {
        static::$disableLogging = true;
    }

    public static function enableLogging(): void
    {
        static::$disableLogging = false;
    }

    public static function withoutLogging($callback)
    {
        static::$loggingStack[] = static::$disableLogging;
        static::disableLogging();

        try {
            return $callback();
        } finally {
            static::$disableLogging = array_pop(static::$loggingStack);
        }
    }

    protected static function isLoggingDisabled(): bool
    {
        $route = request()->route();
        if (!$route) {
            return false;
        }

        $routeName = $route->getName();
        $actionName = $route->getActionName();

        // index ルートの場合はログを無効にする
        if ($routeName && preg_match('/\.index$/', $routeName)) {
            return true;
        }

        // コントローラーの index メソッドの場合もログを無効にする
        if ($actionName && preg_match('/\@index$/', $actionName)) {
            return true;
        }

        return static::$disableLogging;
    }

    // 履歴レコードを作成するメソッド
    public function recordHistory(string $operationType): void
    {
        // 操作タイプに応じて変更内容を取得
        $changes = $this->getChangesForHistory($operationType);

        ModelHistory::create([
            'model' => $this::class,
            'model_type' => $this::class, // ポリモーフィックリレーションのため
            'model_id' => $this->getKey(),
            'user_id' => Auth::id(),
            'operation_type' => $operationType,
            'changes' => $changes,
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
            'meta' => $this->getHistoryMeta(),
        ]);
    }

    protected function getChangesForHistory(string $operationType): ?array
    {
        // 操作タイプに応じて適切な変更内容を返す
        if ($operationType === 'updated') {
            return $this->getChangesWithOriginalExcludingUpdatedAt();
        } elseif ($operationType === 'created') {
            return $this->getAttributesExcludingUpdatedAt();
        }
        // 'deleted' と 'retrieved' の場合はnullを返す
        return null;
    }

    protected function getChangesWithOriginalExcludingUpdatedAt(): array
    {
        $changes = [];
        foreach ($this->getDirty() as $key => $value) {
            // updated_atフィールドを除外
            if ($key !== 'updated_at') {
                $changes[$key] = [
                    'before' => $this->getOriginal($key),
                    'after' => $value
                ];
            }
        }
        return $changes;
    }

    protected function getAttributesExcludingUpdatedAt(): array
    {
        // updated_atを除く全ての属性を返す
        return array_diff_key($this->getAttributes(), ['updated_at' => '']);
    }

    // protected function getHistoryMeta(): ?array
    // {
    //     // オーバーライド可能なメタデータ取得メソッド
    //     // デフォルトではnullを返す
    //     return null;
    // }

    public function histories()
    {
        // モデルの履歴を取得するためのリレーションシップ
        return $this->morphMany(ModelHistory::class, 'model');
    }

    // メタデータを受取りrecordHistoryに渡すためのメソッド
    protected function getHistoryMeta(): ?array
    {
        $meta = [
            'display_name' => $this->getDisplayNameForHistory(),
        ];

        // 追加のメタ情報があれば拡張できるように配列をマージ
        if (method_exists($this, 'getAdditionalHistoryMeta')) {
            $meta = array_merge($meta, $this->getAdditionalHistoryMeta());
        }

        return $meta;
    }

    /**
     * 履歴表示用の名称を取得
     */
    protected function getDisplayNameForHistory(): string
    {
        // モデルごとに表示名の取得ロジックを定義できるようにする
        if (method_exists($this, 'getHistoryDisplayName')) {
            return $this->getHistoryDisplayName();
        }

        // デフォルトの優先順位で名称を取得
        $nameFields = ['name', 'title', 'display_name', 'full_name', 'company_name', 'customer_name'];
        
        foreach ($nameFields as $field) {
            if (isset($this->attributes[$field])) {
                return $this->attributes[$field];
            }
        }

        // どのフィールドも見つからない場合はIDを返す
        return "ID: {$this->getKey()}";
    }
}