<?php

namespace App\Exports;

use App\Models\SupportTime;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithCustomCsvSettings;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithTitle;

class SupportTimesExport implements FromCollection, WithHeadings, WithTitle, WithCustomCsvSettings, ShouldAutoSize, WithMapping
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return SupportTime::select('id', 'code', 'name','is_active','is_searchable')->orderBy('code', 'asc')->get();
    }

    public function headings():array
	{
		return [
				'ID', 
				'コード', 
				'名称', 
				'登録有効/無効', 
				'検索有効/無効', 
			]; 
	}

    public function map($supportTime): array
    {
        return [
            $supportTime->id,
            $supportTime->code,
            $supportTime->name,
            $supportTime->is_active ? '1' : '0',
            $supportTime->is_searchable ? '1' : '0',
        ];
    }


    public function title(): string{

		return 'サポート所要時間マスタ';

	}

    public function getCsvSettings(): array
    {
        return [
            'use_bom' => true
        ];
    }
}
