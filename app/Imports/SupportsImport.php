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
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithCustomCsvSettings;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Validators\Failure;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Throwable;

class SupportsImport implements 
    ToCollection, 
    WithStartRow, 
    WithValidation, 
    WithBatchInserts, 
    WithChunkReading, 
    WithCustomCsvSettings,
    SkipsOnError,
    SkipsOnFailure
{
    use SkipsErrors, SkipsFailures;

    protected $filePath;
    protected $encoding;
    protected $rowCount = 0;
    protected $successCount = 0;
    protected $errors = [];
    protected $validationErrors = [];

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
    }

    public function collection(Collection $rows)
    {
        foreach ($rows as $index => $row) {
            $this->rowCount++;
            $rowNumber = $this->startRow() + $index;

            try {
                // バリデーションを手動で実行
                $this->manualValidate($row, $rowNumber);
                
                // サポートデータの作成
                $support = $this->createSupportFromRow($row, $rowNumber);
                $this->successCount++;
            } catch (Throwable $e) {
                $this->errors[] = [
                    'row' => $rowNumber,
                    'message' => $e->getMessage(),
                    'data' => $row->toArray()
                ];
            }
        }
    }

    protected function manualValidate($row, $rowNumber)
    {
        $rowArray = $row->toArray();
        
        // 配列のキーを列名に変換（デバッグ用）
        $data = [];
        foreach ($rowArray as $index => $value) {
            $columnName = $this->columnNames[$index] ?? "列{$index}";
            $data[$columnName] = $value;
        }

        $validator = Validator::make($rowArray, $this->rules(), $this->customValidationMessages());

        if ($validator->fails()) {
            $errors = $validator->errors();
            $errorMessages = [];
            
            foreach ($errors->messages() as $field => $messages) {
                $columnName = $this->columnNames[$field] ?? "列{$field}";
                foreach ($messages as $message) {
                    $errorMessages[] = "列{$field}({$columnName}): {$message}";
                }
            }
            
            $this->validationErrors[] = [
                'row' => $rowNumber,
                'errors' => $errorMessages,
                'data' => $data
            ];
            
            throw new \Exception(implode(' | ', $errorMessages));
        }
    }

    protected function createSupportFromRow($row, $rowNumber)
    {
        $rowArray = $row->toArray();

        // より詳細なエラーメッセージ
        $client = $this->findClientByNumber($rowArray[0], $rowNumber);
        $user = $this->findUserByNumber($rowArray[2], $rowNumber);

        $support = new Support([
            'client_id' => $client->id,
            'request_num' => Support::generateRequestNumber($client->id),
            'received_at' => $rowArray[1],
            'user_id' => $user->id,
            'client_user_department' => $rowArray[3] ?? null,
            'client_user_kana_name' => $rowArray[4] ?? null,
            'title' => $rowArray[8],
            'request_content' => $rowArray[9],
            'response_content' => $rowArray[10] ?? null,
            'internal_message' => $rowArray[11] ?? null,
            'internal_memo1' => $rowArray[12] ?? null,
            'is_finished' => $this->toBool($rowArray[13] ?? false),
            'is_faq_target' => $this->toBool($rowArray[14] ?? false),
            'is_disclosured' => $this->toBool($rowArray[15] ?? false),
            'is_troubled' => $this->toBool($rowArray[16] ?? false),
            'is_confirmed' => $this->toBool($rowArray[17] ?? false),
        ]);

        $this->setRelatedModels($support, $rowArray, $rowNumber);

        $support->save();

        return $support;
    }

    protected function findClientByNumber($clientNumber, $rowNumber)
    {
        $client = Client::where('client_num', $clientNumber)->first();
        if (!$client) {
            throw new \Exception("行{$rowNumber}: 顧客番号 '{$clientNumber}' に該当する顧客が見つかりません。");
        }
        return $client;
    }

    protected function findUserByNumber($userNumber, $rowNumber)
    {
        $paddedUserNumber = str_pad($userNumber, 6, '0', STR_PAD_LEFT);
        $user = User::where('user_num', $paddedUserNumber)->first();
        if (!$user) {
            throw new \Exception("行{$rowNumber}: 社員番号 '{$userNumber}' (補完後: {$paddedUserNumber}) に該当するユーザーが見つかりません。");
        }
        return $user;
    }

    protected function setRelatedModels($support, $rowArray, $rowNumber)
    {
        // 各関連モデルのIDを検索（エラーメッセージを詳細化）
        $support->product_series_id = $this->findModelId(ProductSeries::class, 'series_code', $rowArray[5] ?? null, 'シリーズコード', $rowNumber);
        $support->product_version_id = $this->findModelId(ProductVersion::class, 'version_code', $rowArray[6] ?? null, 'バージョンコード', $rowNumber);
        $support->product_category_id = $this->findModelId(ProductCategory::class, 'category_code', $rowArray[7] ?? null, '系統コード', $rowNumber);
        $support->support_time_id = $this->findModelId(SupportTime::class, 'time_code', $rowArray[18] ?? null, '所要時間コード', $rowNumber);
        $support->support_type_id = $this->findModelId(SupportType::class, 'type_code', $rowArray[19] ?? null, '種別コード', $rowNumber);
    }

    protected function findModelId($modelClass, $column, $value, $fieldName, $rowNumber)
    {
        if (empty($value)) {
            return null;
        }

        $model = $modelClass::where($column, $value)->first();
        if (!$model) {
            // オプション: 存在しない場合はエラーにせず、nullを返す
            // throw new \Exception("行{$rowNumber}: {$fieldName} '{$value}' が見つかりません。");
            return null;
        }
        return $model->id;
    }

    protected function toBool($value)
    {
        if (is_bool($value)) {
            return $value;
        }
        return in_array(strtolower((string)$value), ['1', 'true', 'yes', 'y', '○', '◯'], true);
    }

    public function rules(): array
    {
        return [
            '0' => 'required', // 顧客番号
            '1' => 'required|date', // 受付日
            '2' => 'required', // 社員番号
            '8' => 'required|max:255', // 表題
            '9' => 'required', // 内容
            '10' => 'nullable', // 回答
            '11' => 'nullable', // 社内連絡欄
            '12' => 'nullable', // 社内メモ欄
            '13' => 'nullable', // 対応完了済
            '14' => 'nullable', // FAQ対象
            '15' => 'nullable', // 顧客開示
            '16' => 'nullable', // トラブル
            '17' => 'nullable', // 入力確認
            '18' => 'nullable', // 所要時間コード
            '19' => 'nullable', // 種別コード
        ];
    }

    public function customValidationMessages()
    {
        $messages = [];
        foreach ($this->columnNames as $index => $name) {
            $messages["{$index}.required"] = "{$name}は必須項目です。";
            $messages["{$index}.max"] = "{$name}は:max文字以内で入力してください。";
            if ($index == 1) {
                $messages["{$index}.date"] = "{$name}には有効な日付を指定してください。";
            }
        }
        return $messages;
    }

    public function startRow(): int
    {
        return 2;
    }

    public function batchSize(): int
    {
        return 100;
    }

    public function chunkSize(): int
    {
        return 100;
    }

    protected function detectEncoding(): string
    {
        $content = file_get_contents($this->filePath);
        $encoding = mb_detect_encoding($content, ['UTF-8', 'SJIS-win', 'eucJP-win', 'ASCII'], true);
        return $encoding ?: 'UTF-8';
    }

    public function getCsvSettings(): array
    {
        return [
            'input_encoding' => $this->encoding,
            'delimiter' => ',',
            'enclosure' => '"',
            'escape' => '\\',
        ];
    }

    // エラーハンドリング用メソッド
    public function onError(Throwable $e)
    {
        $this->errors[] = [
            'type' => 'error',
            'message' => $e->getMessage(),
            'trace' => $e->getTraceAsString()
        ];
    }

    public function onFailure(Failure ...$failures)
    {
        foreach ($failures as $failure) {
            $this->validationErrors[] = [
                'row' => $failure->row(),
                'attribute' => $failure->attribute(),
                'errors' => $failure->errors(),
                'values' => $failure->values()
            ];
        }
    }

    // 結果取得用メソッド
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
        return $this->errors;
    }

    public function getValidationErrors(): array
    {
        return $this->validationErrors;
    }

    public function getFailedCount(): int
    {
        return count($this->errors) + count($this->validationErrors);
    }

    public function hasErrors(): bool
    {
        return !empty($this->errors) || !empty($this->validationErrors);
    }

    // 詳細なエラーレポートを生成
    public function getErrorReport(): array
    {
        return [
            'total_rows' => $this->rowCount,
            'success_count' => $this->successCount,
            'failed_count' => $this->getFailedCount(),
            'validation_errors' => $this->validationErrors,
            'processing_errors' => $this->errors,
            'summary' => [
                'has_errors' => $this->hasErrors(),
                'error_rate' => $this->rowCount > 0 ? round(($this->getFailedCount() / $this->rowCount) * 100, 2) : 0
            ]
        ];
    }
}