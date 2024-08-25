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
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\WithCustomCsvSettings;
use Throwable;

class SupportsImport implements ToModel, WithStartRow, WithValidation, WithBatchInserts, WithChunkReading, SkipsOnError, SkipsOnFailure, WithCustomCsvSettings
{
    use SkipsErrors, SkipsFailures;

    protected $filePath;
    protected $encoding;
    protected $rowCount = 0;

    public function __construct(string $filePath)
    {
        $this->filePath = $filePath;
        $this->encoding = $this->detectEncoding();
    }

    public function startRow(): int
    {
        return 2; // CSVファイルの2行目からデータの読み込みを開始
    }

    protected function detectEncoding(): string
    {
        $content = file_get_contents($this->filePath);
        $encoding = mb_detect_encoding($content, ['UTF-8', 'SJIS-win', 'eucJP-win', 'ASCII'], true);
        return $encoding ?: 'SJIS-win';
    }

    public function getCsvSettings(): array
    {
        return [
            'input_encoding' => $this->encoding,
            'delimiter' => ',',
            'enclosure' => '"'
        ];
    }

    public function model(array $row)
    {
        $this->rowCount++;
    
        try {
            $client = Client::where('client_num', $row[0])->firstOrFail();
            $user = User::where('user_num', str_pad($row[2], 6, '0', STR_PAD_LEFT))->firstOrFail();
    
            $support = new Support([
                'client_id' => $client->id,
                'request_num' => Support::generateRequestNumber($client->id),
                'received_at' => $row[1],
                'user_id' => $user->id,
                'client_user_department' => $row[3],
                'client_user_kana_name' => $row[4],
                'title' => $row[8],
                'request_content' => $row[9],
                'response_content' => $row[10],
                'internal_message' => $row[11],
                'internal_memo1' => $row[12],
                'is_finished' => $this->toBool($row[13]),
                'is_faq_target' => $this->toBool($row[14]),
                'is_disclosured' => $this->toBool($row[15]),
                'is_troubled' => $this->toBool($row[16]),
                'is_confirmed' => $this->toBool($row[17]),
            ]);
    
            $support->product_series_id = ProductSeries::where('series_code', $row[5])->value('id');
            $support->product_version_id = ProductVersion::where('version_code', $row[6])->value('id');
            $support->product_category_id = ProductCategory::where('category_code', $row[7])->value('id');
            $support->support_time_id = SupportTime::where('time_code', $row[18])->value('id');
            $support->support_type_id = SupportType::where('type_code', $row[19])->value('id');
    
            return $support;
        } catch (Throwable $e) {
            $this->onError($e);
            return null;
        }
    }

    public function onError(Throwable $e)
    {
        $row = $this->getRowFromError($e);
        
        // エラーログの記録
        \Log::error('Error importing row: ' . ($row ? json_encode($row) : 'Unknown row'));
        \Log::error('Error message: ' . $e->getMessage());
        \Log::error('Stack trace: ' . $e->getTraceAsString());
    }

    /**
     * エラーオブジェクトから行データを抽出する
     *
     * @param Throwable $e
     * @return array|null
     */
    private function getRowFromError(Throwable $e): ?array
    {
        $reflection = new \ReflectionObject($e);
        if ($reflection->hasProperty('row')) {
            $property = $reflection->getProperty('row');
            $property->setAccessible(true);
            return $property->getValue($e);
        }
        return null;
    }

    private function toBool($value): bool
    {
        return in_array(strtolower($value), ['1', 'true', 'yes', 'y'], true);
    }

    public function getRowCount(): int
    {
        return $this->rowCount;
    }

    public function rules(): array
    {
        return [
            '0' => 'required',
            '1' => 'required|date',
            '2' => 'required',
            // 他のバリデーションルールを追加
        ];
    }

    public function batchSize(): int
    {
        return 1000;
    }

    public function chunkSize(): int
    {
        return 1000;
    }
}