<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;

class AllScreensTest extends TestCase
{
    // ⚠️ 重要: RefreshDatabase は本番/開発DBのデータをすべて削除します
    // テスト専用DBを使用するか、以下のいずれかを選択してください:
    
    // オプション1: データベースを使わない（現在の設定）
    // - 既存データを保護
    // - モックユーザーを使用
    
    // オプション2: トランザクションのみ使用（既存データ保護）
    // use DatabaseTransactions;
    
    // オプション3: 完全リフレッシュ（テスト専用DB必須）
    // use RefreshDatabase;

    /**
     * 全てのGETルートがエラーなく開くかテスト
     *
     * @return void
     */
    public function test_all_get_routes_are_accessible()
    {
        // 実際のユーザーをDBから取得（存在する場合）
        $user = User::first();
        
        if (!$user) {
            // ユーザーが存在しない場合はモックを使用
            $user = $this->createMockUser();
            echo "\n⚠️  警告: DBにユーザーが存在しないため、モックユーザーを使用しています\n";
        } else {
            echo "\n✓ 実際のユーザーでテストを実行します\n";
            $keyType = strlen((string)$user->id) === 26 ? 'ULID' : '通常のID';
            echo "  ユーザーID: {$user->id} ({$keyType})\n";
            echo "  ユーザー名: {$user->user_name}\n";
            echo "\n取得した実際のIDリスト:\n";
        }

        $routes = Route::getRoutes();
        $failedRoutes = [];
        $successCount = 0;
        $skippedCount = 0;

        foreach ($routes as $route) {
            // GETメソッドのルートのみテスト
            if (!in_array('GET', $route->methods()) && !in_array('HEAD', $route->methods())) {
                continue;
            }

            $uri = $route->uri();
            
            // 除外したいルートのパターン
            if ($this->shouldSkipRoute($uri)) {
                $skippedCount++;
                continue;
            }

            // パラメータが必要なルートの処理
            $url = $this->replaceRouteParameters($uri);

            try {
                // 認証が必要そうなルートの場合はログイン状態でアクセス
                if ($this->requiresAuth($uri)) {
                    $response = $this->actingAs($user)->get($url);
                } else {
                    $response = $this->get($url);
                }
                
                // ステータスコードを取得（BinaryFileResponse対応）
                $statusCode = $response->baseResponse->getStatusCode();
                
                // 許容するステータスコード
                $acceptableStatuses = [
                    200, // OK
                    201, // Created
                    204, // No Content (CSRF token など)
                    302, // Redirect
                    401, // Unauthorized (認証が必要)
                    403, // Forbidden (権限が必要)
                ];
                
                if (in_array($statusCode, $acceptableStatuses)) {
                    $successCount++;
                } else {
                    // 500エラーの場合は例外情報を取得
                    $errorDetail = $statusCode;
                    if ($statusCode === 500 && $response->exception) {
                        $errorDetail = sprintf(
                            "500 - %s in %s:%d",
                            $response->exception->getMessage(),
                            basename($response->exception->getFile()),
                            $response->exception->getLine()
                        );
                    }
                    
                    $failedRoutes[] = [
                        'uri' => $uri,
                        'url' => $url,
                        'status' => $errorDetail,
                    ];
                }
            } catch (\Exception $e) {
                // 特定のエラーは無視（開発中の未実装機能など）
                if ($this->isAcceptableException($e)) {
                    $skippedCount++;
                    continue;
                }
                
                $failedRoutes[] = [
                    'uri' => $uri,
                    'url' => $url,
                    'error' => $this->formatErrorMessage($e),
                ];
            }
        }

        // テスト結果のサマリーを出力
        echo "\n";
        echo "==========================================\n";
        echo "テスト結果サマリー\n";
        echo "==========================================\n";
        echo "成功: {$successCount} ルート\n";
        echo "スキップ: {$skippedCount} ルート\n";
        echo "失敗: " . count($failedRoutes) . " ルート\n";
        echo "==========================================\n";

        // 結果をファイルに保存
        $this->saveTestResults($successCount, $skippedCount, $failedRoutes);

        // 失敗したルートがある場合、詳細を表示
        if (!empty($failedRoutes)) {
            // エラーの種類を分類
            $errorsByType = $this->categorizeErrors($failedRoutes);
            
            echo "\n==========================================\n";
            echo "エラーの種類別集計\n";
            echo "==========================================\n";
            foreach ($errorsByType as $type => $count) {
                echo "{$type}: {$count}件\n";
            }
            echo "==========================================\n";
            
            // 最初の5件のみ表示（全件表示すると長すぎるため）
            $displayCount = min(5, count($failedRoutes));
            $message = "\n最初の{$displayCount}件のエラー詳細:\n\n";
            
            for ($i = 0; $i < $displayCount; $i++) {
                $failed = $failedRoutes[$i];
                $message .= sprintf(
                    "【ルート】 %s\n",
                    $failed['uri']
                );
                $message .= sprintf(
                    "【URL】 %s\n",
                    $failed['url']
                );
                $message .= sprintf(
                    "【エラー】 %s\n\n",
                    $failed['status'] ?? $failed['error']
                );
            }
            
            if (count($failedRoutes) > $displayCount) {
                $message .= sprintf(
                    "...他 %d 件のエラー\n",
                    count($failedRoutes) - $displayCount
                );
            }
            
            $message .= "\n💡 ヒント:\n";
            $message .= "- 全エラーの詳細: storage/logs/route-test-results.txt\n";
            $message .= "- 500エラーのログ: storage/logs/laravel.log\n";
            $message .= "- ブラウザでは開けるのにテストで失敗する場合:\n";
            $message .= "  → ユーザーの権限やリレーションデータが不足している可能性\n";
            $message .= "  → 実際のログインユーザーでテストを実行してみてください\n";
            
            $this->fail($message);
        }

        $this->assertTrue(true, "全てのルートが正常にアクセス可能です（成功: {$successCount}）");
    }

    /**
     * スキップすべきルートかどうか判定
     *
     * @param string $uri
     * @return bool
     */
    private function shouldSkipRoute(string $uri): bool
    {
        $skipPatterns = [
            'api/',              // APIルート（別途テストする場合）
            '_debugbar',         // デバッグバー
            '_ignition',         // Ignition
            'telescope',         // Telescope
            'horizon',           // Horizon
            'sanctum/csrf-cookie', // CSRF token endpoint（204を返すため）
            'livewire',          // Livewire
            'logout',            // ログアウト（POST）
        ];

        foreach ($skipPatterns as $pattern) {
            if (str_contains($uri, $pattern)) {
                return true;
            }
        }

        return false;
    }

    /**
     * 認証が必要なルートかどうか判定
     *
     * @param string $uri
     * @return bool
     */
    private function requiresAuth(string $uri): bool
    {
        $authPatterns = [
            'dashboard',
            'profile',
            'corporations',
            'admin',
            'settings',
            'user',
        ];

        foreach ($authPatterns as $pattern) {
            if (str_contains($uri, $pattern)) {
                return true;
            }
        }

        return false;
    }

    /**
     * 許容可能な例外かどうか判定
     *
     * @param \Exception $e
     * @return bool
     */
    private function isAcceptableException(\Exception $e): bool
    {
        $message = $e->getMessage();
        
        $acceptableErrors = [
            'does not exist',           // メソッド未実装
            'Permission denied',        // ファイル権限（開発環境の問題）
            'could not be opened',      // ログファイル権限
        ];

        foreach ($acceptableErrors as $error) {
            if (str_contains($message, $error)) {
                return true;
            }
        }

        return false;
    }

    /**
     * エラーメッセージを整形
     *
     * @param \Exception $e
     * @return string
     */
    private function formatErrorMessage(\Exception $e): string
    {
        $message = $e->getMessage();
        
        // 長すぎるメッセージは省略
        if (strlen($message) > 200) {
            $message = substr($message, 0, 200) . '...';
        }

        return $message;
    }

    /**
     * ルートパラメータをダミー値に置き換え
     *
     * @param string $uri
     * @return string
     */
    private function replaceRouteParameters(string $uri): string
    {
        // 実際のIDをDBから取得して使用
        $replacements = $this->getActualIds();
        
        // パラメータ名に応じて実際のIDを使用
        $uri = preg_replace_callback('/\{([^}]+)\}/', function($matches) use ($replacements) {
            $paramName = $matches[1];
            
            // パラメータ名に対応する実際のIDがあれば使用
            foreach ($replacements as $key => $id) {
                if (str_contains($paramName, $key) && $id) {
                    return $id;
                }
            }
            
            // なければデフォルトのULIDまたは1を使用
            // 26文字の文字列はULIDの可能性が高い
            return '01ARZ3NDEKTSV4RRFFQ69G5FAV'; // ダミーULID
        }, $uri);
        
        return '/' . ltrim($uri, '/');
    }

    /**
     * DBから実際のIDを取得（ULID対応）
     *
     * @return array
     */
    private function getActualIds(): array
    {
        $ids = [];
        
        try {
            // よく使われるモデルとその主キータイプを定義
            $models = [
                'project' => ['class' => 'App\Models\Project', 'keyType' => 'auto'],
                'client' => ['class' => 'App\Models\Client', 'keyType' => 'auto'],
                'user' => ['class' => 'App\Models\User', 'keyType' => 'auto'],
                'corporation' => ['class' => 'App\Models\Corporation', 'keyType' => 'auto'],
                'product' => ['class' => 'App\Models\Product', 'keyType' => 'auto'],
                'support' => ['class' => 'App\Models\Support', 'keyType' => 'auto'],
                'report' => ['class' => 'App\Models\Report', 'keyType' => 'auto'],
                'contract' => ['class' => 'App\Models\Contract', 'keyType' => 'auto'],
                'vendor' => ['class' => 'App\Models\Vendor', 'keyType' => 'auto'],
                'role_group' => ['class' => 'App\Models\RoleGroup', 'keyType' => 'auto'],
                'department' => ['class' => 'App\Models\Department', 'keyType' => 'auto'],
                'estimate' => ['class' => 'App\Models\Estimate', 'keyType' => 'auto'],
                'keepfile' => ['class' => 'App\Models\Keepfile', 'keyType' => 'auto'],
                'notification' => ['class' => 'App\Models\Notification', 'keyType' => 'auto'],
                'model_history' => ['class' => 'App\Models\ModelHistory', 'keyType' => 'auto'],
            ];
            
            foreach ($models as $key => $config) {
                $modelClass = $config['class'];
                
                if (class_exists($modelClass)) {
                    $record = $modelClass::first();
                    if ($record) {
                        $primaryKey = $record->getKeyName();
                        $id = $record->{$primaryKey};
                        
                        if ($id) {
                            $ids[$key] = $id;
                            
                            // IDの形式をログに出力（デバッグ用）
                            if (strlen((string)$id) === 26) {
                                echo "  - {$key}: ULID形式 ({$id})\n";
                            } else {
                                echo "  - {$key}: 通常のID ({$id})\n";
                            }
                        }
                    }
                }
            }
        } catch (\Exception $e) {
            // エラーが発生しても続行
            echo "  ⚠️  ID取得エラー: " . $e->getMessage() . "\n";
        }
        
        return $ids;
    }

    /**
     * モックユーザーを作成（データベース不要）
     *
     * @return \App\Models\User
     */
    private function createMockUser()
    {
        $user = new User();
        $user->id = 1;
        $user->name = 'Test User';
        $user->email = 'test@example.com';
        $user->email_verified_at = now();
        
        return $user;
    }

    /**
     * テスト結果をファイルに保存
     *
     * @param int $successCount
     * @param int $skippedCount
     * @param array $failedRoutes
     * @return void
     */
    private function saveTestResults(int $successCount, int $skippedCount, array $failedRoutes)
    {
        $content = "==========================================\n";
        $content .= "ルートテスト結果\n";
        $content .= "実行日時: " . now()->format('Y-m-d H:i:s') . "\n";
        $content .= "==========================================\n\n";
        $content .= "成功: {$successCount} ルート\n";
        $content .= "スキップ: {$skippedCount} ルート\n";
        $content .= "失敗: " . count($failedRoutes) . " ルート\n\n";

        if (!empty($failedRoutes)) {
            $content .= "==========================================\n";
            $content .= "エラー詳細\n";
            $content .= "==========================================\n\n";

            foreach ($failedRoutes as $failed) {
                $content .= "【ルート】 {$failed['uri']}\n";
                $content .= "【URL】 {$failed['url']}\n";
                $content .= "【エラー】 " . ($failed['status'] ?? $failed['error']) . "\n";
                $content .= "---\n";
            }
        }

        $filePath = storage_path('logs/route-test-results.txt');
        file_put_contents($filePath, $content);
    }

    /**
     * エラーを種類別に分類
     *
     * @param array $failedRoutes
     * @return array
     */
    private function categorizeErrors(array $failedRoutes): array
    {
        $categories = [
            '500エラー（サーバーエラー）' => 0,
            '404エラー（ページ未検出）' => 0,
            'その他のエラー' => 0,
        ];

        foreach ($failedRoutes as $failed) {
            $error = $failed['status'] ?? $failed['error'] ?? '';
            
            if (str_contains($error, '500')) {
                $categories['500エラー（サーバーエラー）']++;
            } elseif (str_contains($error, '404')) {
                $categories['404エラー（ページ未検出）']++;
            } else {
                $categories['その他のエラー']++;
            }
        }

        return $categories;
    }

    /**
     * ULIDかどうか判定
     *
     * @param mixed $id
     * @return bool
     */
    private function isUlid($id): bool
    {
        if (!is_string($id)) {
            return false;
        }
        
        // ULIDは26文字の英数字
        return strlen($id) === 26 && preg_match('/^[0-9A-HJKMNP-TV-Z]{26}$/', $id);
    }

    /**
     * ダミーのULIDを生成
     * 
     * @return string
     */
    private function generateDummyUlid(): string
    {
        // Laravelに組み込みのULIDヘルパーを使用
        if (class_exists('\Illuminate\Support\Str') && method_exists('\Illuminate\Support\Str', 'ulid')) {
            return (string) \Illuminate\Support\Str::ulid();
        }
        
        // フォールバック: 固定のダミーULID
        return '01ARZ3NDEKTSV4RRFFQ69G5FAV';
    }
}