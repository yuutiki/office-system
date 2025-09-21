<?php

namespace App\Traits;

use App\Models\ModelHistory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

trait ModelHistoryTrait
{
    protected static $disableLogging = false;
    protected static $loggingStack = [];

    // 除外するカラムのデフォルトリスト
    protected static $defaultExcludedColumns = [
        'updated_at',
        'last_login_at',
    ];

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
            'user_agent_client_hint' => $this->getUaClientHints(),   // UA-CH追加
            'meta' => $this->getHistoryMeta(),
        ]);
    }

    protected function getChangesForHistory(string $operationType): ?array
    {
        // 操作タイプに応じて適切な変更内容を返す
        if ($operationType === 'updated') {
            return $this->getChangesWithOriginalExcludingUpdatedAt();
        } elseif ($operationType === 'created') {
            // return $this->getAttributesExcludingUpdatedAt();
            //         // "after" に作成データを入れる
            $attributes = $this->getAttributesExcludingUpdatedAt();
            return array_map(fn($value) => ['before' => null, 'after' => $value], $attributes);
        }
        // 'deleted' と 'retrieved' の場合はnullを返す
        return null;
    }

    // 除外するカラムを取得するメソッド
    protected function getExcludedColumns(): array
    {
        // モデルで個別に除外カラムを定義できるようにする
        $modelExcludedColumns = property_exists($this, 'excludeFromHistory')
            ? $this->excludeFromHistory
            : [];

        return array_merge(static::$defaultExcludedColumns, $modelExcludedColumns);
    }

    protected function getChangesWithOriginalExcludingUpdatedAt(): array
    {
        $changes = [];
        $excludedColumns = $this->getExcludedColumns();

        foreach ($this->getDirty() as $key => $value) {
            // 除外するカラムリストに含まれていない場合のみ記録
            if (!in_array($key, $excludedColumns)) {
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
        // 除外するカラムを配列に変換してdiff_keyで除外
        $excludeKeys = array_flip($this->getExcludedColumns());
        return array_diff_key($this->getAttributes(), $excludeKeys);
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

    protected function getUaClientHints(): ?array
    {
        $request = request();

        return [
            'ua'       => $request->header('Sec-CH-UA'),
            'mobile'   => $request->header('Sec-CH-UA-Mobile'),
            'platform' => $request->header('Sec-CH-UA-Platform'),
            'arch'     => $request->header('Sec-CH-UA-Arch'),
            'model'    => $request->header('Sec-CH-UA-Model'),
        ];
    }

}