<?php

namespace App\Imports;

use App\Models\SupportTime;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;

class SupportTimesImport implements ToModel, WithHeadingRow, WithValidation, SkipsOnError, SkipsOnFailure
{
    use SkipsErrors, SkipsFailures;

    /**
     * 1行ごとにモデルへ変換
     */
    public function model(array $row)
    {
        // IDが存在する場合は更新、存在しない場合は新規
        $supportTime = SupportTime::find($row['id']) ?? new SupportTime();

        $supportTime->fill([
            'code'          => $row['コード'],
            'name'          => $row['名称'],
            'is_active'     => (bool) $row['登録有効/無効'],
            'is_searchable' => (bool) $row['検索有効/無効'],
        ]);

        return $supportTime;
    }

    /**
     * バリデーションルール
     */
    public function rules(): array
    {
        return [
            '*.コード' => ['required', 'string', 'max:2'],
            '*.名称' => ['required', 'string', 'max:20'],
            '*.登録有効/無効' => ['required', Rule::in(['0', '1', 0, 1])],
            '*.検索有効/無効' => ['required', Rule::in(['0', '1', 0, 1])],
        ];
    }

    /**
     * 見出し行（ヘッダー）は1行目
     */
    public function headingRow(): int
    {
        return 1;
    }
}
