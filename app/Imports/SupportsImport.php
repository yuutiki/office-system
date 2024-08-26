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


use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Throwable;

class SupportsImport implements ToCollection, WithStartRow, WithValidation, WithBatchInserts, WithChunkReading, WithCustomCsvSettings
{
    protected $filePath;
    protected $encoding;
    protected $rowCount = 0;
    protected $successCount = 0;
    protected $errors = [];

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
        DB::beginTransaction();
    
        try {
            foreach ($rows as $index => $row) {
                $this->rowCount++;
                $rowNumber = $this->startRow() + $index;
    
                try {
                    $this->validateRow($row, $rowNumber);
                    $support = $this->createSupportFromRow($row, $rowNumber);
                    $this->successCount++;
                } catch (Throwable $e) {
                    $this->errors[] = [
                        'row' => $rowNumber,
                        'message' => $e->getMessage()
                    ];
                }
            }
    
            if (!empty($this->errors)) {
                DB::rollBack();
                throw new \Exception('インポート中にエラーが発生しました。');
            }
    
            DB::commit();
        } catch (Throwable $e) {
            DB::rollBack();
            throw $e;
        }
    }

    protected function validateRow($row, $rowNumber)
    {
        $rowArray = $row->toArray();
        $validator = \Validator::make($rowArray, $this->rules(), $this->customValidationMessages());
    
        if ($validator->fails()) {
            $failures = new ValidationException($validator, $validator->errors());
            $failures->setRowNumber($rowNumber);
            throw $failures;
        }
    }

    protected function createSupportFromRow($row, $rowNumber)
    {
        $rowArray = $row->toArray();

        $client = $this->findClientByNumber($rowArray[0]);
        $user = $this->findUserByNumber($rowArray[2]);

        $support = new Support([
            'client_id' => $client->id,
            'request_num' => Support::generateRequestNumber($client->id),
            'received_at' => $rowArray[1],
            'user_id' => $user->id,
            'client_user_department' => $rowArray[3],
            'client_user_kana_name' => $rowArray[4],
            'title' => $rowArray[8],
            'request_content' => $rowArray[9],
            'response_content' => $rowArray[10],
            'internal_message' => $rowArray[11],
            'internal_memo1' => $rowArray[12],
            'is_finished' => $this->toBool($rowArray[13]),
            'is_faq_target' => $this->toBool($rowArray[14]),
            'is_disclosured' => $this->toBool($rowArray[15]),
            'is_troubled' => $this->toBool($rowArray[16]),
            'is_confirmed' => $this->toBool($rowArray[17]),
        ]);

        $this->setRelatedModels($support, $rowArray);

        $support->save();

        return $support;
    }

    protected function findClientByNumber($clientNumber)
    {
        $client = Client::where('client_num', $clientNumber)->first();
        if (!$client) {
            throw new \Exception("Client not found for client_num: {$clientNumber}");
        }
        return $client;
    }

    protected function findUserByNumber($userNumber)
    {
        $user = User::where('user_num', str_pad($userNumber, 6, '0', STR_PAD_LEFT))->first();
        if (!$user) {
            throw new \Exception("User not found for user_num: {$userNumber}");
        }
        return $user;
    }

    protected function setRelatedModels($support, $rowArray)
    {
        $support->product_series_id = $this->findModelId(ProductSeries::class, 'series_code', $rowArray[5]);
        $support->product_version_id = $this->findModelId(ProductVersion::class, 'version_code', $rowArray[6]);
        $support->product_category_id = $this->findModelId(ProductCategory::class, 'category_code', $rowArray[7]);
        $support->support_time_id = $this->findModelId(SupportTime::class, 'time_code', $rowArray[18]);
        $support->support_type_id = $this->findModelId(SupportType::class, 'type_code', $rowArray[19]);
    }

    protected function findModelId($modelClass, $column, $value)
    {
        $model = $modelClass::where($column, $value)->first();
        return $model ? $model->id : null;
    }

    protected function toBool($value)
    {
        return in_array(strtolower($value), ['1', 'true', 'yes', 'y'], true);
    }

    public function rules(): array
    {
        return [
            '0' => 'required',
            '1' => 'required|date',
            '2' => 'required',
            '8' => 'required',
            '9' => 'required',
            // 他のバリデーションルールを必要に応じて追加
        ];
    }

    public function customValidationMessages()
    {
        $messages = [];
        foreach ($this->columnNames as $index => $name) {
            $messages["{$index}.required"] = "{$name}列は必須項目です。";
            if ($index == 1) {
                $messages["{$index}.date"] = "{$name}列には有効な日付を指定してください。";
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
            'enclosure' => '"'
        ];
    }

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
}