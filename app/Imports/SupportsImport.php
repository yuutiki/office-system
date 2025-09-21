<?php

namespace App\Imports;

use App\Models\Support;
use App\Models\Client;
use App\Models\User;
use App\Models\ProductSeries;
use App\Models\ProductVersion;
use App\Models\ProductCategory;
use App\Models\SupportTime;
use App\Models\SupportType;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithCustomCsvSettings;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Row;
use Maatwebsite\Excel\Validators\Failure;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;
use Throwable;

class SupportsImport implements 
    ToModel, 
    WithStartRow, 
    WithChunkReading, 
    WithCustomCsvSettings,
    WithValidation,
    WithBatchInserts,
    SkipsOnError,
    SkipsOnFailure
{
    use SkipsErrors, SkipsFailures;

    protected $filePath;
    protected $encoding;
    protected $rowCount = 0;
    protected $successCount = 0;
    protected $customErrors = [];
    
    // キャッシュ用の配列
    protected static $clientCache = [];
    protected static $userCache = [];
    protected static $masterDataCache = [];
    protected static $requestNumberCounters = [];

    protected $columnNames = [
        0 => '顧客番号',
        1 => '受付日',
        2 => '社員番号',
        3 => '担当者部署',
        4 => '担当者名',
        5 => 'シリーズ',
        6 => 'バージョン',
        7 => '系統',
        8 => '表題',
        9 => '内容',
        10 => '回答',
        11 => '社内連絡欄',
        12 => '社内メモ欄',
        13 => '対応完了済',
        14 => 'FAQ対象',
        15 => '顧客開示',
        16 => 'トラブル',
        17 => '入力確認',
        18 => '所要時間コード',
        19 => '種別コード',
    ];

    public function __construct(string $filePath)
    {
        $this->filePath = $filePath;
        $this->encoding = $this->detectEncoding();
        $this->preloadMasterData();
    }

    protected function detectEncoding(): string
    {
        $cacheKey = 'csv_encoding_' . md5_file($this->filePath);
        
        return Cache::remember($cacheKey, 3600, function() {
            $content = file_get_contents($this->filePath, false, null, 0, 1024);
            $encoding = mb_detect_encoding($content, ['CP932', 'UTF-8', 'SJIS', 'EUC-JP'], true);
            
            return $encoding ?: 'UTF-8';
        });
    }

    public function getCsvSettings(): array
    {
        return [
            'input_encoding' => $this->encoding,
            'delimiter' => ',',
            'enclosure' => '"',
            'escape' => '\\',
            'use_bom' => false,
            'output_encoding' => 'UTF-8',
        ];
    }

    protected function preloadMasterData()
    {
        // マスターデータをキャッシュから取得するか、DBから取得してキャッシュする
        self::$masterDataCache = Cache::remember('import_master_data', 300, function() {
            return [
                'series' => ProductSeries::pluck('id', 'series_code')->toArray(),
                'versions' => ProductVersion::pluck('id', 'version_code')->toArray(),
                'categories' => ProductCategory::pluck('id', 'category_code')->toArray(),
                'times' => SupportTime::pluck('id', 'code')->toArray(),
                'types' => SupportType::pluck('id', 'type_code')->toArray(),
            ];
        });
        
        // リクエスト番号のカウンターを初期化
        $this->initializeRequestNumberCounters();
    }

    protected function initializeRequestNumberCounters()
    {
        if (empty(self::$requestNumberCounters)) {
            $maxNumbers = Support::selectRaw('client_id, MAX(request_num) as max_num')
                ->groupBy('client_id')
                ->pluck('max_num', 'client_id')
                ->toArray();
            
            foreach ($maxNumbers as $clientId => $maxNum) {
                self::$requestNumberCounters[$clientId] = $maxNum + 1;
            }
        }
    }

    public function model(array $row)
    {
        $this->rowCount++;
        
        try {
            // 文字化け対策
            $row = $this->convertEncoding($row);
            
            // クライアントとユーザーの取得
            $client = $this->getClient($row[0]);
            $user = $this->getUser($row[2]);
            
            if (!$client) {
                throw new \Exception("顧客番号 {$row[0]} が見つかりません");
            }
            
            if (!$user) {
                throw new \Exception("社員番号 {$row[2]} が見つかりません");
            }
            
            $this->successCount++;
            
            return new Support([
                'client_id' => $client->id,
                'request_num' => $this->getNextRequestNumber($client->id),
                'received_at' => $this->parseDate($row[1]),
                'user_id' => $user->id,
                'client_user_department' => $row[3] ?? null,
                'client_user_kana_name' => $row[4] ?? null,
                'product_series_id' => $this->getMasterDataId('series', $row[5] ?? null),
                'product_version_id' => $this->getMasterDataId('versions', $row[6] ?? null),
                'product_category_id' => $this->getMasterDataId('categories', $row[7] ?? null),
                'title' => $row[8],
                'request_content' => $row[9],
                'response_content' => $row[10] ?? null,
                'internal_message' => $row[11] ?? null,
                'internal_memo1' => $row[12] ?? null,
                'is_finished' => $this->toBool($row[13] ?? null),
                'is_faq_target' => $this->toBool($row[14] ?? null),
                'is_disclosured' => $this->toBool($row[15] ?? null),
                'is_troubled' => $this->toBool($row[16] ?? null),
                'is_confirmed' => $this->toBool($row[17] ?? null),
                'support_time_id' => $this->getMasterDataId('times', $row[18] ?? null),
                'support_type_id' => $this->getMasterDataId('types', $row[19] ?? null),
            ]);
            
        } catch (\Exception $e) {
            // カスタムエラーとして記録
            $this->customErrors[] = [
                'row' => $this->rowCount,
                'message' => $e->getMessage(),
                'type' => 'processing',
            ];
            throw $e;
        }
    }

    public function rules(): array
    {
        return [
            '0' => 'required', // 顧客番号
            '1' => 'required|date', // 受付日
            '2' => 'required', // 社員番号
            '8' => 'required|max:255', // 表題
            '9' => 'required', // 内容
        ];
    }

    public function customValidationMessages()
    {
        return [
            '0.required' => '顧客番号は必須です',
            '1.required' => '受付日は必須です',
            '1.date' => '受付日の形式が不正です',
            '2.required' => '社員番号は必須です',
            '8.required' => '表題は必須です',
            '8.max' => '表題は255文字以内で入力してください',
            '9.required' => '内容は必須です',
        ];
    }

    protected function convertEncoding($row)
    {
        foreach ($row as $key => $value) {
            if (is_string($value)) {
                // 金額のカンマ対応（エスケープされたカンマを一時的に置換）
                $value = str_replace('\\,', '[COMMA]', $value);
                
                // エンコーディング変換
                if (!mb_check_encoding($value, 'UTF-8')) {
                    $value = mb_convert_encoding($value, 'UTF-8', $this->encoding);
                }
                
                // カンマを元に戻す
                $value = str_replace('[COMMA]', ',', $value);
                
                $row[$key] = trim($value);
            }
        }
        return $row;
    }

    protected function getClient($clientNumber)
    {
        if (empty($clientNumber)) {
            return null;
        }
        
        if (!isset(self::$clientCache[$clientNumber])) {
            self::$clientCache[$clientNumber] = Client::where('client_num', $clientNumber)->first();
        }
        return self::$clientCache[$clientNumber];
    }

    protected function getUser($userNumber)
    {
        if (empty($userNumber)) {
            return null;
        }
        
        $paddedNumber = str_pad($userNumber, 6, '0', STR_PAD_LEFT);
        if (!isset(self::$userCache[$paddedNumber])) {
            self::$userCache[$paddedNumber] = User::where('user_num', $paddedNumber)->first();
        }
        return self::$userCache[$paddedNumber];
    }

    protected function getMasterDataId($type, $code)
    {
        if (empty($code)) {
            return null;
        }
        return self::$masterDataCache[$type][$code] ?? null;
    }

    protected function getNextRequestNumber($clientId)
    {
        if (!isset(self::$requestNumberCounters[$clientId])) {
            self::$requestNumberCounters[$clientId] = 1;
        }
        
        $num = self::$requestNumberCounters[$clientId];
        self::$requestNumberCounters[$clientId]++;
        return $num;
    }

    protected function parseDate($date)
    {
        if (empty($date)) {
            return null;
        }
        
        try {
            return \Carbon\Carbon::parse($date)->format('Y-m-d');
        } catch (\Exception $e) {
            throw new \Exception("日付の形式が不正です: {$date}");
        }
    }

    protected function toBool($value)
    {
        if (empty($value)) {
            return false;
        }
        
        return in_array(strtolower($value), ['1', 'true', 'yes', 'y', '○', '◯'], true);
    }

    public function startRow(): int
    {
        return 2;
    }

    public function batchSize(): int
    {
        return 1000;
    }
    
    public function chunkSize(): int
    {
        return 1000;
    }

    public function onError(Throwable $e)
    {
        // エラーの詳細情報をログに記録
        Log::error('Import error at row ' . $this->getRowCount(), [
            'error' => $e->getMessage(),
            'row' => $this->getRowCount(),
        ]);
    }

    public function onFailure(Failure ...$failures)
    {
        // バリデーションエラーの処理
        foreach ($failures as $failure) {
            $this->customErrors[] = [
                'row' => $failure->row(),
                'message' => implode(', ', $failure->errors()),
                'type' => 'validation',
                'attribute' => $this->columnNames[$failure->attribute()] ?? $failure->attribute(),
            ];
        }
    }

    // ゲッターメソッド
    public function getRowCount(): int
    {
        return $this->rowCount;
    }

    public function getSuccessCount(): int
    {
        return $this->successCount;
    }

    public function getErrors(): array
    {
        $allErrors = array_merge($this->customErrors);
        
        // エラーを行番号でソート
        usort($allErrors, function($a, $b) {
            return $a['row'] <=> $b['row'];
        });
        
        return $allErrors;
    }

    public function hasErrors(): bool
    {
        return !empty($this->customErrors);
    }

    public function getErrorCount(): int
    {
        return count($this->customErrors);
    }
}